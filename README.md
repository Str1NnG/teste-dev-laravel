# 🚀 Laravel LoremIpsum Blog

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

## 📄 Descrição
Um sistema web de blog que consome a API externa da **DummyJSON** para importar usuários, posts e comentários, persistindo todos os dados no banco relacional MySQL e oferecendo uma interface interativa e responsiva.

O projeto demonstra o uso de **Laravel** para backend, consumo de APIs, comandos Artisan personalizados e interface moderna com **Tailwind CSS**.

---

## 🛠️ Tecnologias Utilizadas

- 🐘 **Laravel 12** (Framework PHP)
- 🐬 **MySQL** (Banco de Dados)
- 🎨 **Tailwind CSS v4** (Estilização via Vite)
- ⚡ **Javascript (Fetch API)** (Interatividade AJAX)

## ✨ Funcionalidades

- ✅ **Importação de Dados:** Comando personalizado (`app:import-dummy`) para popular o banco via API.
- ✅ **Listagem e Paginação:** Exibição de posts com paginação otimizada.
- ✅ **Busca e Filtros:** Pesquisa por título e filtro clicável por Tags.
- ✅ **Interatividade:** Sistema de Like/Dislike em tempo real (sem recarregar a página).
- ✅ **Contador de Views:** Incremento automático de visualizações.
- ✅ **Navegação Relacional:** Posts vinculados a usuários e comentários.

---

## ⚙️ Instalação

### 📦 Pré-requisitos
* PHP 8.2+
* Composer
* Node.js & NPM
* MySQL

### 🚀 Passos

**1. Clone o repositório**
```bash
git clone https://github.com/Str1NnG/teste-dev-laravel.git
cd teste-dev-laravel
```

**2. Instale as dependências**
```bash
composer install
npm install
```

**3. Configure o banco de dados**
* Copie o arquivo de exemplo:
```bash
cp .env.example .env
```
* Abra o arquivo `.env` e configure suas credenciais do MySQL:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog_loremipsum
DB_USERNAME=root
DB_PASSWORD=
```

**4. Gere a chave da aplicação**
```bash
php artisan key:generate
```

**5. Execute as migrations**
* Isso criará as tabelas no banco de dados.
```bash
php artisan migrate
```

**6. Popule o banco de dados (Importante)**
* Execute o comando personalizado para baixar os dados da API DummyJSON:
```bash
php artisan app:import-dummy
```

**7. Inicie o servidor**
* Você precisará de dois terminais rodando simultaneamente:

*Terminal 1 (Backend Laravel):*
```bash
php artisan serve
```

*Terminal 2 (Frontend/Vite):*
```bash
npm run dev
```

**8. Acesse o projeto**
* Abra http://127.0.0.1:8000 no seu navegador.

---

## 📺 Apresentação do Projeto

Confira o sistema funcionando neste vídeo demonstrativo:

[]

---

<div align="center">
    Developed with ❤️ by <a href="https://github.com/Str1NnG">Str1NnG</a> for the Laravel Test Challenge.
</div>