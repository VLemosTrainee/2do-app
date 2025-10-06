<p align="center"><a href="https://64.media.tumblr.com/97d3f7d4cb6937db3572de7b6c0d1453/b3abd6c5be8de38e-31/s540x810/f9f4d9bf918c9e1ef50d8d31423178c70c5b33d0.pnj" target="_blank"><img src="https://64.media.tumblr.com/97d3f7d4cb6937db3572de7b6c0d1453/b3abd6c5be8de38e-31/s540x810/f9f4d9bf918c9e1ef50d8d31423178c70c5b33d0.pnj" width="250" alt="2DO Logo"></a></p>


<p align="center">
    <!-- LOGOTIPOS DAS TECNOLOGIAS DO 2DO -->
    <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
    <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
    <img src="https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white" alt="Alpine.js">
    <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

# 🚀 2DO: Plataforma de Gestão de Trabalho e Colaboração

## Sobre o 2DO

O 2DO é uma plataforma de gestão de trabalho desenvolvida com Laravel e foco em colaboração. Não se trata apenas de uma lista de afazeres pessoal, mas sim de uma ferramenta robusta para gerenciar projetos e tarefas em ambientes de grupo e individual. A plataforma foi criada para fornecer aos administradores uma visão completa e centralizada do fluxo de trabalho.

Nossa interface prioriza a UI/UX, utilizando Tailwind CSS para ser totalmente responsiva e moderna, com foco em cores harmoniosas baseadas no Azul Turquesa/Teal.

### Principais Características Técnicas

*   Frontend Reativo com **Alpine.js** (utilizado para contagem dinâmica, filtros e manipulação de formulários em modal).
*   Estrutura de Roteamento otimizada para separação entre rotas de Administrador e Usuário Comum.
*   **Dashboard Gerencial** detalhada com KPIs e visualizações de prioridade em tempo real.
*   CRUD completo para Projetos, Equipes e Usuários.

## Funcionalidades de Gestão

O 2DO facilita a gestão de trabalho através de módulos essenciais:

-   **Dashboard Centralizada:** Visão executiva com KPIs de progresso, tarefas pendentes e concluídas.
-   **Distribuição de Prioridades:** Destaque visual e quantitativo das tarefas classificadas como Alta, Média e Baixa.
-   **Gestão de Equipes (Teams):** Criação de grupos e vinculação a projetos específicos.
-   **Alocação de Tarefas:** Atribuição de tarefas a membros específicos e acompanhamento de status (Concluído/Pendente).
-   **Interface de Edição Rápida:** Edição de tarefas via modal (para a lista de gestão) e formulário dedicado (para criação).

## Como Instalar e Iniciar

### Pré-requisitos

*   PHP >= 8.2
*   Composer
*   Node.js & npm (ou Yarn)

### Instalação

1.  **Clone o repositório:**
    ```bash
    git clone [URL_DO_SEU_REPOSITÓRIO] 2do-app
    cd 2do-app
    ```

2.  **Instale as dependências PHP:**
    ```bash
    composer install
    ```

3.  **Configure o ambiente (.env):**
    ```bash
    cp .env.example .env
    # Edite o .env com suas credenciais de banco de dados (DB)
    ```

4.  **Gere a chave da aplicação:**
    ```bash
    php artisan key:generate
    ```

5.  **Instale e compile os assets do Frontend:**
    ```bash
    npm install
    npm run dev # Utilize 'npm run build' para produção
    ```

6.  **Execute as migrações e seeders:**
    ```bash
    php artisan migrate --seed
    ```

7.  **Inicie o servidor local:**
    ```bash
    php artisan serve
    ```
    
Acesse o sistema via `http://127.0.0.1:8000`.

## Aprendendo mais sobre Laravel

O 2DO é baseado no Laravel. Para aprender mais sobre o framework subjacente, confira estes recursos:

- [Documentação Oficial do Laravel](https://laravel.com/docs)
- [Laravel Bootcamp](https://bootcamp.laravel.com)
- [Laracasts (Tutoriais em vídeo)](https://laracasts.com)

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).


## Contribuindo

Thank you for considering contributing to the 2DO project! We value community input.

## Code of Conduct

In order to ensure that the 2DO community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Segurança

Se você descobrir uma vulnerabilidade de segurança no projeto 2DO, por favor, entre em contato.

## Licença

The 2DO platform is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
