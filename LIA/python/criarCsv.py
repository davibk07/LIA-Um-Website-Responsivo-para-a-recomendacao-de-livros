import requests
import pandas as pd
import time

# ===== CONFIGURAÇÕES =====
categories = [
    "Fiction", "Nonfiction", "History", "Science", "Philosophy", "Education", "Science Fiction & Fantasy", 
    "Medical", "Education & Teaching", "History & Criticism", "Poetry", 
    "Drama", "Nature", "Children's Books", "Young Adult",
    "Detective & Mystery", "Fantasy", "Historical Fiction", "Thriller & Suspense", "Adventure"
]
books_per_category = 200
batch_size = 40
lang = "pt"
output_file = "livros_relevantes.csv"

# ===== FUNÇÃO DE COLETA =====
def collect_books_for_category(category):
    collected = []
    for start in range(0, books_per_category, batch_size):
        url = (
            "https://www.googleapis.com/books/v1/volumes?"
            f"q=subject:{category}&printType=books"
            f"&orderBy=relevance&startIndex={start}&maxResults={batch_size}"
        )
        print(f"📚 {category}: coletando livros {start + 1}–{start + batch_size}...")
        response = requests.get(url)
        data = response.json()

        for item in data.get("items", []):
            info = item.get("volumeInfo", {})
            sale = item.get("saleInfo", {})
            imagem = info.get("imageLinks", {})
            collected.append({
                "id": item.get("id"),
                "title": info.get("title"),
                "subtitle": info.get("subtitle"),
                "authors": ", ".join(info.get("authors", [])),
                "publisher": info.get("publisher"),
                "publishedDate": info.get("publishedDate"),
                "description": info.get("description"),
                "pageCount": info.get("pageCount"),
                "categories": ", ".join(info.get("categories", [])),
                "language": info.get("language"),
                "averageRating": info.get("averageRating"),
                "ratingsCount": info.get("ratingsCount"),
                "previewLink": info.get("previewLink"),
                "buyLink": sale.get("buyLink"),
                "mainCategory": category,
                "imagem": imagem.get('thumbnail')
            })
        time.sleep(1)  # evita exceder limite de requisições
    return collected

# ===== COLETA GERAL =====
all_books = []
seen_ids = set()

for cat in categories:
    books = collect_books_for_category(cat)
    for b in books:
        if b["id"] not in seen_ids:
            seen_ids.add(b["id"])
            all_books.append(b)

# ===== SALVAR =====
df = pd.DataFrame(all_books)
df.to_csv(output_file, index=False, encoding="utf-8")

print(f"\n✅ CSV gerado: {output_file}")
print(f"Total de livros coletados: {len(df)}")