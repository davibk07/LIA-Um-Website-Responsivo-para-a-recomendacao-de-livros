# LIA-Um-Website-Responsivo-para-a-recomendacao-de-livros

# Autores 
Davi Bazzanella Kuhn - Técnico em Informática pelo IFRS - Campus Farroupilha 
Miguel Freitas da Rosa - Técnico em Informática pelo IFRS - Campus Farroupilha 

# Sobre o projeto 
Projeto de conclusão de curso desenvolvido no IFRS - Campus Farroupilha. A justificativa do projeto se dá pelo baixo número de leitores no Brasil, segundo dados do instituto Pró-Livro, 53% da população é considerada não leitora - ou seja, não leu sequer uma parte de um livro nos últimos três meses. O LIA busca incentivar o hábito da leitura por meio de um website responsivo. O sistema recomenda livros automaticamente, combinando similaridade textual e metadados, proporcionando uma experiência personalizada e interativa para os usuários. 

# Tecnologias
Análise textual com TF-IDF
Similaridade de Cosseno para medir proximidade entre livros 
Pesos ponderados: 40% texto, 60% metadados (autor, categoria, avaliação média) 
Filtragem de resultados baseada no CSV de livros coletados via API 

# Interface 
Website responsivo e intuitivo, adaptável a desktops, tablets e celulares 
Catálogo de livros pesquisável 
Sistema de recomendação personalizado 
Perfil do usuário com livros salvos e recomendados 
Interação via like/dislike para feedback do algoritmo 

# Como executar localmente 
Instalar XAMPP (Apache, MySQL, PHP) 
Importar database.sql no MySQL 
Configurar a conexão no PHP 
Rodar scripts Python para recomendação 
Acessar localhost no navegador
