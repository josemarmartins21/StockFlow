# StockFlow
Sistema de gestão de estoque
## Requisitos

- PHP 8.2 ou superior - Conferir a versão: php -v
- Composer - Conferir a instalação: composer --version
- Node.js 22 ou superior - Conferir a versão: node -v
## Como intalar o sistema?
### Roda o comando a seguir:

```
composer install
```

Renomeia o arquivo **.env.example** para **.env**
Mude as credenciais do banco dentro do arquivo **.env.example**
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

```
php artisan serve
```

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





