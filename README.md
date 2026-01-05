<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>

# Sistema de Gestão de Tarefas

Aplicação web para gestão de tarefas diárias, desenvolvida no âmbito de um estágio na Inovcorp onde utilizei: Laravel, Vue 3 e Tailwind CSS.

O projeto tem como objetivo aplicar boas práticas de desenvolvimento web moderno, com foco em organização de código, usabilidade, acessibilidade, segurança e testes automatizados.


## Tecnologias Utilizadas

- **Backend:** Laravel 12  
- **Frontend:** Vue 3 + Inertia.js  
- **Estilização:** Tailwind CSS  
- **Base de Dados:** MySQL  
- **Autenticação:** Laravel Breeze  


## Funcionalidades

A aplicação permite ao utilizador gerir tarefas de forma simples e eficiente, incluindo:

- Criação, edição e remoção de tarefas
- Definição de prioridade e prazo
- Marcação de tarefas como concluídas
- Sistema de filtros por estado, prioridade e prazo
- Visualização de detalhes em modal
- Interface responsiva e acessível


## Arquitetura da Aplicação

O projeto segue as convenções do Laravel, com separação clara de responsabilidades no backend e uma interface construída com componentes Vue reutilizáveis.

A comunicação entre frontend e backend é realizada através do Inertia.js.


## Testes Automatizados

A aplicação inclui testes automatizados com **Pest**, focados principalmente na gestão de tarefas.

Os testes garantem que:
- Utilizadores autenticados conseguem criar, editar e eliminar as suas tarefas
- Cada utilizador apenas tem acesso às suas tarefas
- Não é possível visualizar, modificar ou remover tarefas de outros utilizadores


## Responsividade, Acessibilidade e Segurança

A aplicação foi desenvolvida com atenção a boas práticas de usabilidade e segurança, incluindo:

- Layout responsivo para mobile, tablet e desktop
- Navegação completa por teclado
- Uso de ARIA labels e HTML semântico
- Validação de dados no backend
- Proteção CSRF e controlo de acesso por utilizador


## Desenvolvedor

**André Loureiro**  
Estagiário em Desenvolvimento Web – Inovcorp

