# Algina

A Aligna se apresenta como uma ferramenta de gerenciamento de procedimentos e processos operacionais de uma empresa. A rotina no dia a dia torna difícil de verificar e acompanhar as atividades básicas de funções na empresa, uma gestão eficaz dos Procedimentos Operacionais Padrão (POP), Cargos, Processos e Funções de uma equipe com detalhamento, documentos auxiliares e instruções detalhadas melhoram a performance de qualquer trabalho.

# Instruções

Composer install
npm watch 
configurar .env com a base de dados
rodar as migrations
Após dar o Composer install modificar todos os models do passport com o useTenantConnection (lembrar de importar, exemplo nos models) e excluir a função "getConnectionName" nos models.
rodar o artisan server
fazer um post na rota : /tenancy/new (definir o content-type:json) com o json: {"hostname":"SeuHost.com","website":"seuhost"} 
Configurar o xamp ou wamp para aceitar virtual host