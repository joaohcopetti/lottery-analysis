# Análise de jogos da loterias Caixa

Projeto que fornece um painel para analisar os resultados das loterias Caixa, como Mega-Sena.

## Setup

#### Na raiz do projeto:
##### Backend
- Copie o `.env.example` para `.env`: `cp .env.example .env`.
- Suba os containers: `docker compose up`.
- Entre no container: `docker exec -it lottery-analysis-app bash`.
- Instale as dependencias do backend: `composer install`.
- Gera a chave: `php artisan key:generate`.
- Rode os migrations com os seeds padrões: `php artisan migrate --seed`
- Busque os jogos da Mega Sena, por exemplo: `php artisan app:fetch-lottery mega-sena`

##### Frontend
- Rode `pnpm install`
- Suba o frontend `pnpm dev`

Acesse o projeto em: http://localhost:8000
