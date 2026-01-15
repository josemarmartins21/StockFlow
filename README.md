# StockFlow
Sistema de gestão de estoque para bares


# Galeria do Sistema

## Página Inicial 
![pagina inicial](/public/assets/galeria/imagens_do_sistema/pagina-inicial.png)

## Página de Vendas
![pagina de vendas](/public/assets/galeria/imagens_do_sistema/pagina_de_vendas.png)

## Página de Detalhes do Produto
![página de detalhes do produto](/public/assets/galeria/imagens_do_sistema/show_gasosa.png)

## Página de Categorias
![página de categorias](/public/assets/galeria/imagens_do_sistema/página_de_categorias%20.png)

## Fatura Gerada Pelo Sistema
![fatura](/public/assets/galeria/imagens_do_sistema/fatura.png)
## Requisitos

- PHP 8.2 ou superior - Conferir a versão: php -v
- Composer - Conferir a instalação: composer --version
- Node.js 22 ou superior - Conferir a versão: node -v
## Como intalar o sistema?
### Roda o comando a seguir:
Instalar as dependências do **PHP**
```
composer install
```
Instalar as dependências do **node.js**
```
npm install
```
Renomeia o arquivo **.env.example** para **.env**
mas antes mude as credenciais do banco no arquivo **.env.example**
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco_de_dados
DB_USERNAME=usuario_do_banco_de_dados
DB_PASSWORD=senha_do_usuario_do_banco_de_dados
```
### Roda as migrations com:
```
php artisan migrate
```
### Excute o projecto com estes comandos abaixo:
Rodar o servidor para executar o **Laravel**
```
php artisan serve
```
Rodar o servidor para rodar o node.js
```
npm run dev
```
***

# Em caso de duvidas podes entrar em contacto comigo:
- **Whatsapp:** +244 940 121 011
- **Email:** josemar21@outlook.pt

## Tips
### Comando para importar o Sweet Alert na App
```
import Swal from 'sweetalert2'
window.Swal = Swal
```





