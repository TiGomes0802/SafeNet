<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        
        // Tabela Ranks (id, nome, imagem, maximo, minimo)
        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('imagem')->nullable();
            $table->integer('maximo');
            $table->integer('minimo');
        });

        // Alterar tabela Users (idRanke)
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('idRanke')->nullable();
            $table->foreign('idRanke')->references('id')->on('ranks')->onDelete('cascade');
        });

        // Lista de Amigos (id, status, idUser1, idUser2)
        Schema::create('amigos', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->unsignedBigInteger('idUser1');
            $table->unsignedBigInteger('idUser2');
            $table->foreign('idUser1')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idUser2')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabela Curso (id, ordem, status)
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->integer('ordem');
            $table->string('status');
        });

        // Tabela Unidade (id, titulo, ordem, status, idCurso)
        Schema::create('unidades', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->integer('ordem');
            $table->string('status');
            $table->unsignedBigInteger('idCurso');
            $table->foreign('idCurso')->references('id')->on('cursos')->onDelete('cascade');
        });

        // Tabela Pagina (id, descricao, ordem, idUnidade)
        Schema::create('paginas', function (Blueprint $table) {
            $table->id();
            $table->text('descricao');
            $table->integer('ordem');
            $table->unsignedBigInteger('idUnidade');
            $table->foreign('idUnidade')->references('id')->on('unidades')->onDelete('cascade');
        });

        // Tabela Tipo (id, tipo)
        Schema::create('tipoJogos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
        });

        // Tabela Jogo (id, xp, estado, idUser, idGestor, idTipo, idUnidade)
        Schema::create('jogos', function (Blueprint $table) {
            $table->id();
            $table->integer('xp');
            $table->string('estado');
            $table->unsignedBigInteger('idUser');
            $table->unsignedBigInteger('idGestor');
            $table->unsignedBigInteger('idTipo');
            $table->unsignedBigInteger('idUnidade');
            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idGestor')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idTipo')->references('id')->on('tipoJogos')->onDelete('cascade');
            $table->foreign('idUnidade')->references('id')->on('unidades')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabela Resposta (id, resposta, tipo, certa, idJogo)
        Schema::create('respostas', function (Blueprint $table) {
            $table->id();
            $table->string('resposta');
            $table->boolean('certa');
            $table->unsignedBigInteger('idJogo');
            $table->foreign('idJogo')->references('id')->on('jogos')->onDelete('cascade');
        });

        // Tabela Estatistica (id, numVezes, numAcertos, idJogo, idUtilizador)
        Schema::create('estatisticas', function (Blueprint $table) {
            $table->id();
            $table->integer('numVezes');
            $table->integer('numAcertos');
            $table->unsignedBigInteger('idJogo');
            $table->unsignedBigInteger('idUtilizador');
            $table->foreign('idJogo')->references('id')->on('jogos')->onDelete('cascade');
            $table->foreign('idUtilizador')->references('id')->on('users')->onDelete('cascade');
        });

        // Tabela Reports (id, mensagem, status, idUtilizador, idGestor)
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->text('mensagem');
            $table->string('status');
            $table->unsignedBigInteger('idUtilizador');
            $table->unsignedBigInteger('idGestor');
            $table->foreign('idUtilizador')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idGestor')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabela TipoProduto (id, tipo)
        Schema::create('tipoProduto', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
        });

        // Tabela Produto (id, nome, preco, idTipoProduto)
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->integer('preco');
            $table->unsignedBigInteger('idTipoProduto');
            $table->foreign('idTipoProduto')->references('id')->on('tipoProduto')->onDelete('cascade');
        });

        // Tabela Compras (id, idUser, idProduto)
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idUser');
            $table->unsignedBigInteger('idProduto');
            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idProduto')->references('id')->on('produtos')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabela Missoes (id, tipo, estado, descricao, presente, objetivo)
        Schema::create('missoes', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->string('estado');
            $table->text('descricao');
            $table->integer('objetivo');
        });

        // Tabela Users_Missoes (id, idUser, idMissao)
        Schema::create('users_missoes', function (Blueprint $table) {
            $table->id();
            $table->string('estado');
            $table->integer('presente');
            $table->unsignedBigInteger('idUser');
            $table->unsignedBigInteger('idMissao');
            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idMissao')->references('id')->on('missoes')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabela LinksExternos (id, nome, url, idCurso)
        Schema::create('linksExternos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('url');
            $table->unsignedBigInteger('idCurso');
            $table->foreign('idCurso')->references('id')->on('cursos')->onDelete('cascade');
        });

    }

    public function down(): void {
        // Schema::dropIfExists('ranks');
        // Schema::dropIfExists('amigos');
        // Schema::dropIfExists('cursos');
        // Schema::dropIfExists('unidades');
        // Schema::dropIfExists('paginas');
        // Schema::dropIfExists('tipoJogos');
        // Schema::dropIfExists('jogos');
        // Schema::dropIfExists('respostas');
        // Schema::dropIfExists('estatisticas');
        // Schema::dropIfExists('reports');
        // Schema::dropIfExists('tipoProduto');
        // Schema::dropIfExists('produtos');
        // Schema::dropIfExists('compras');
        // Schema::dropIfExists('missoes');
        // Schema::dropIfExists('users_missoes');
        // Schema::dropIfExists('linksExternos');
    }
};
