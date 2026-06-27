# Análise de jogos da loterias Caixa

Projeto que fornece um painel para analisar os resultados das loterias Caixa, como Mega-Sena.

## Funcionalidades
> A API oficial da Caixa parou de atualizar os resultados, último resultado é do dia 24/01/2026.

- Automaticamente busca jogos das loterias com comando `php artisan app:lottery-fetch`.
- Exibe em um grid semelhante aos cartões de jogos reais, com mapa de calor.
- Ordenação por ocorrências ou jogos.
- Selecionar número para visualizar em destaque no painel.
- Filtrar jogos por data.

## Demo
<img width="1920" height="933" alt="Screenshot 2026-06-25 at 12-19-59 Lottery analysis" src="https://github.com/user-attachments/assets/23b13018-c8cc-4e6b-a487-ee357ad6b758" />
<img width="1920" height="933" alt="Screenshot 2026-06-25 at 12-22-31 Lottery analysis" src="https://github.com/user-attachments/assets/355fc3d6-a141-4a2b-9b11-ed963d53f378" />

## Setup

#### Na raiz do projeto:
##### Backend
- Copie o `.env.example` para `.env`: `cp .env.example .env`.
- Suba os containers: `docker compose up`.
- Entre no container: `docker exec -it lottery-analysis-app bash`.
- Dentro do container:
  - Instale as dependencias do backend: `composer install`.
  - Gera a chave: `php artisan key:generate`.
  - Rode os migrations com os seeds padrões: `php artisan migrate --seed`
  - Busque os jogos da Mega Sena, por exemplo: `php artisan app:fetch-lottery mega-sena`

##### Frontend
- Rode `pnpm install`
- Suba o frontend `pnpm dev`

Acesse o projeto em: http://localhost:8000
