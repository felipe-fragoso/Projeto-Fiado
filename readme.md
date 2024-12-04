# <img alt="Ícone FiadoFacil" src="public/img/fiado-logo.png" width="32" style="vertical-align: bottom"> FiadoFacil

# O que é o FiadoFacil?

Projeto ilustrativo de um sistema de fiado para comérciantes e clientes,
onde o cliente e comérciante podem gerenciar suas contas com mais facilidade e transparência.
Substituindo a antiga caderneta de fiado por algo mais moderno.

# Instalação

## Requisitos
- PHP 8.2 ou superior
- Composer
- MySQL

## Instalando

> [!NOTE]
> Caso ja possua o Composer instalado pule a primeria etapa.

1. Primeiramente instale o [Composer](https://getcomposer.org/) seguindo a documentação do proprio site.
2. Clone esse repositório.
3. Depois de instalar o Composer utilize o seguinte comando no repositório do projeto:

```
php composer.phar install
```
4. Instale e configure um Banco de dados MySQL.
5. Importe a estrutura do Banco de dados com o arquivo `database/estrutura.sql`.

## Configurando

1. Faça uma copia do arquivo `.env.example`
2. Remova a parte '.example' do arquivo ficando apenas `.env`
3. Configure os valores do arquivo `.env` conforme o seu ambiente.
