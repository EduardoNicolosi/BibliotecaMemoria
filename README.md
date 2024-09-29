# BibliotecaMemoria
TDE - Database Performance Tuning
Primeiro realizar o download do MYSQL Workbench e do XAMPP
Realizei a confecção de um banco de dados simples para uma biblioteca, onde a única table é livros e contem os atributos ID(PK), Nome, Ano_lancamento, Autor.
Depois, criei um arquivo chamado conexao.php que contém código para conectar ao banco de dados.
Os demais arquivos.php que utilizam da conexão com o banco de dados precisam fazer o processo de <?php
require '../conexaobd/conexao.php';
Há um php para deletar e um para edicao que puxa um formulário simples para realizar o mesmo.
