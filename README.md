# 🚀 EduSearch - Plataforma Inteligente de Estudos

**EduSearch** é uma plataforma de estudos com IA generativa para orientação automatizada em tópicos educacionais. Desenvolvido como projeto semestral de ADS.

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=flat&logo=laravel&logoColor=white)
![Python](https://img.shields.io/badge/Python-3776AB?style=flat&logo=python&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=flat&logo=docker&logoColor=white)

---

## ✨ Funcionalidades Principais
- **🔍 Busca Inteligente por Tópicos**  
  Geração automática de conteúdo educacional via IA (LangChain + Google Generative AI)
- **📚 Níveis de Aprendizado**  
  Materiais organizados em Iniciante/Intermediário/Avançado
- **🤝 Colaboração**  
  Compartilhamento de pastas de estudo entre usuários
- **📝 Sistema de Anotações**  
  Adição de notas personalizadas em cada tópico
- **💬 Chat Interativo**  
  Interface de conversação integrada


---

## 🛠️ Tecnologias Utilizadas

- **Backend**: Laravel 9.x (PHP)  
- **IA**: Python + LangChain + Google Generative AI  
- **Banco de Dados**: MySQL  
- **Infraestrutura**: Docker Compose (Apache, MySQL, Python)  
- **Frontend**: Bootstrap 5 + JavaScript  

---

## ⚙️ Instalação

1. Clone o repositório  
   ```
   git clone https://github.com/arthurbritosouza/EduSearch.git
   cd EduSearch
   ```
2. Crie o arquivo de variáveis de ambiente para o Python  
   ```
   echo "GOOGLE_API_KEY=sua_chave_aqui" > python_final/.env
   ```
3. Inicie todos os serviços Docker  
   ```
   ./dockerUp.sh edusearch
   ```
4. Acesse no navegador  
   ```
   http://0.0.0.0:8078/login
   ```

---

## 🐳 Estrutura do Docker Compose

```
version: '3.8'
services:
  project_careca:
    build:  
      context: .
      dockerfile: Dockerfile
    container_name: edusearch
    restart: always
    ports:  
      - "8078:80"
    volumes:
      - .:/var/www/html
    environment:
      - API_ENDPOINT=http://api:8001
    networks:
      - edusearch_network

  api:
    build:
      context: ./python_final
      dockerfile: Dockerfile
    container_name: api
    restart: always
    ports:
      - "8001:8001"
    volumes:
      - ./python_final:/var/www/html/api
    networks:
      - edusearch_network

  db:
    image: mysql:8.0
    container_name: edusearch_db
    restart: always
    ports:
      - "3307:3306"
    environment:
      MYSQL_ROOT_PASSWORD: 7877
      MYSQL_DATABASE: EduSearch
    volumes:
      - db:/var/lib/mysql
    networks:
      - edusearch_network

networks:
  edusearch_network:
    driver: bridge

volumes:
  db:
    driver: local
```

---

🎉 Obrigado por conferir o **EduSearch**!
