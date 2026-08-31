# Encurtador de URLs

Aplicação web para encurtar URLs, construída com **Laravel 10**, **SQLite** e **Tailwind CSS v4** (fontes Geist).

## Funcionalidades

- Encurtar URLs via formulário na página inicial (`POST /shorten`)
- Códigos curtos únicos de 7 caracteres gerados aleatoriamente
- Redirecionamento automático para a URL original (`GET /{code}`)
- Contador de cliques por link encurtado
- Lista dos 5 links mais recentes na página inicial
- Validação de URL (obrigatória, formato válido, máximo de 2048 caracteres)

## Requisitos

- PHP >= 8.1
- Composer
- Node.js >= 18

## Instalação

```bash
# Instalar dependências PHP
composer install

# Instalar dependências JavaScript
npm install

# Configurar o ambiente
cp .env.example .env
php artisan key:generate
```

Configure o SQLite no `.env`:

```env
DB_CONNECTION=sqlite
```

Crie o banco de dados e rode as migrations:

```bash
touch database/database.sqlite
php artisan migrate
```

## Uso

Inicie o servidor de desenvolvimento:

```bash
# Terminal 1 — backend Laravel
php artisan serve

# Terminal 2 — assets frontend (Vite + Tailwind)
npm run dev
```

Acesse [http://127.0.0.1:8000](http://127.0.0.1:8000), cole uma URL no formulário e clique em encurtar.

Para build de produção dos assets:

```bash
npm run build
```

## Estrutura principal

| Arquivo | Descrição |
|---|---|
| `app/Http/Controllers/ShortUrlController.php` | Controlador com as ações de encurtar, redirecionar e listar |
| `app/Models/ShortUrl.php` | Model com geração de código único e lookup por `code` |
| `database/migrations/2026_08_31_000000_create_short_urls_table.php` | Tabela `short_urls` (url original, código, cliques) |
| `resources/views/welcome.blade.php` | Interface com Tailwind v4 |
| `routes/web.php` | Rotas da aplicação |

## Testes

A suíte cobre encurtamento, redirecionamento, validação e casos de 404:

```bash
php artisan test
```

## Licença

MIT
