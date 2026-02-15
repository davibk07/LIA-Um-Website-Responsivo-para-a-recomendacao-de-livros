import sys
import json
import pandas as pd
import requests
import unidecode
import io
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import linear_kernel

sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')

# Lê CSV
dfBooks = pd.read_csv(r"C:\xampp\htdocs\tcc\python\livros_relevantes.csv", encoding="utf-8")

# Preenche campos vazios
dfBooks['authors'] = dfBooks['authors'].fillna('')
dfBooks['categories'] = dfBooks['categories'].fillna('')
dfBooks['pageCount'] = dfBooks['pageCount'].fillna(dfBooks['pageCount'].median())
dfBooks['averageRating'] = dfBooks.get('averageRating', pd.NA).fillna(dfBooks['averageRating'].median())
dfBooks['averageRating'] = dfBooks['averageRating'].fillna(dfBooks['averageRating'].median())
dfBooks['description'] = dfBooks['description'].fillna('')
dfBooks['image'] = dfBooks['imagem'].fillna('')

# Normaliza descrições (remove acentos e minúsculas)
dfBooks['desc_clean'] = dfBooks['description'].apply(lambda x: unidecode.unidecode(x.lower()))

# Cria TF-IDF da descrição
tfidf = TfidfVectorizer(stop_words='english')
tfidf_matrix = tfidf.fit_transform(dfBooks['desc_clean'])

# Função para buscar livro na API
def fetch_book_from_api(id):
    url = f"https://www.googleapis.com/books/v1/volumes/{id}"
    response = requests.get(url)
    data = response.json()
    if "error" in data or "volumeInfo" not in data:
        return None
    info = data['volumeInfo']
    book = {
        'id': data.get('id', id),
        'title': info.get('title', ''),
        'categories': [cat.strip() for cat in info.get('categories', [])],
        'authors': [auth.strip() for auth in info.get('authors', [])],
        'pageCount': info.get('pageCount', dfBooks['pageCount'].median()),
        'averageRating': info.get('averageRating', dfBooks['averageRating'].median()),
        'description': info.get('description', ''),
    }
    book['desc_clean'] = unidecode.unidecode(book['description'].lower())
    return book

def recommenderBooks_multi(ids, nRecommendation=5, weight_structured=0.6, weight_text=0.4):
    all_sim_struct = []
    all_sim_text = []

    for id in ids:
        book = fetch_book_from_api(id)
        if book is None:
            continue
        corpus = [book['desc_clean']] + dfBooks['desc_clean'].tolist()
        tfidf_temp = TfidfVectorizer(stop_words='english')
        tfidf_matrix_temp = tfidf_temp.fit_transform(corpus)
        cosine_sim_text = linear_kernel(tfidf_matrix_temp[0], tfidf_matrix_temp[1:]).flatten()

        def score_structured(row):
            s = 0
            row_cats = [c.strip() for c in row['categories'].split(',')]
            if any(cat in row_cats for cat in book['categories']):
                s += 4
            row_auths = [a.strip() for a in row['authors'].split(',')]
            if any(auth in row_auths for auth in book['authors']):
                s += 3
            if abs(row['averageRating'] - book['averageRating']) <= 1:
                s += 2
            return s

        all_sim_struct.append(dfBooks.apply(score_structured, axis=1))
        all_sim_text.append(cosine_sim_text)

    if not all_sim_struct:
        return pd.DataFrame()

    # Média das similaridades entre todos os livros de entrada
    mean_struct = pd.concat(all_sim_struct, axis=1).mean(axis=1)
    mean_text = pd.DataFrame(all_sim_text).T.mean(axis=1)

    dfBooks['Similarity'] = weight_structured * mean_struct + weight_text * mean_text

    # Remove livros que foram passados como entrada
    mask = ~dfBooks['id'].str.contains('|'.join(ids), case=False, na=False)
    dfBooks_filtered = dfBooks[mask]

    # Ordena e pega os 5 melhores
    recs = dfBooks_filtered.sort_values(by='Similarity', ascending=False).head(nRecommendation)

    return recs[['id', 'title', 'authors', 'categories', 'pageCount', 'averageRating', 'Similarity', 'image']].reset_index(drop=True)


if __name__ == "__main__":
    if len(sys.argv) > 1:
        try:
            ids = json.loads(sys.argv[1])
        except ValueError:
            ids = []
    if len(sys.argv) > 2:
        try:
            nRecommendation = int(sys.argv[2])
        except ValueError:
            nRecommendation = 5
    
    recs = recommenderBooks_multi(ids, nRecommendation)
    print(json.dumps(recs.to_dict(orient="records"), ensure_ascii=False))