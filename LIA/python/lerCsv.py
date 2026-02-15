import pandas as pd

df = pd.read_csv(r"C:\xampp\htdocs\tcc\python\livros_relevantes.csv", encoding="utf-8")
print(df.head())
print(df.info())