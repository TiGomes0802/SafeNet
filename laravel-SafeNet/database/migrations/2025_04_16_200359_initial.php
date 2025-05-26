<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {

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
            $table->unsignedBigInteger('idRank')->nullable();
            $table->foreign('idRank')->references('id')->on('ranks')->onDelete('cascade');
        });

        // Lista de Amigos (id, status, idUser1, idUser2)
        Schema::create('amigos', function (Blueprint $table) {
            $table->id();
            $table->boolean('status');
            $table->unsignedBigInteger('idUser1');
            $table->unsignedBigInteger('idUser2');
            $table->foreign('idUser1')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idUser2')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabela Curso (id, ordem, estado)
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->boolean('estado');
        });

        // Tabela Unidade (id, titulo, ordem, estado, idCurso)
        Schema::create('unidades', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->integer('ordem');
            $table->boolean('estado');
            $table->unsignedBigInteger('idCurso');
            $table->foreign('idCurso')->references('id')->on('cursos')->onDelete('cascade');
        });

        // Tabela User_Unidade (id, status, idUser, idUnidade)
        Schema::create('user_unidades', function (Blueprint $table) {
            $table->id();
            $table->boolean('status');
            $table->unsignedBigInteger('idUser');
            $table->unsignedBigInteger('idUnidade');
            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idUnidade')->references('id')->on('unidades')->onDelete('cascade');
        });

        // Tabela Pagina (id, descricao, ordem, idUnidade)
        Schema::create('paginas', function (Blueprint $table) {
            $table->id();
            $table->longText('descricao');
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
            $table->boolean('estado');
            $table->string('pergunta');
            $table->unsignedBigInteger('idUser')->nullable();
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

        // Tabela Estatistica (id, numVezes, numAcertos, idJogo, idUser)
        Schema::create('estatisticas', function (Blueprint $table) {
            $table->id();
            $table->integer('numVezes');
            $table->integer('numAcertos');
            $table->unsignedBigInteger('idJogo');
            $table->unsignedBigInteger('idUser');
            $table->foreign('idJogo')->references('id')->on('jogos')->onDelete('cascade');
            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
        });

        // Tabela Reports (id, mensagem, status, idUser, idGestor)
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->text('mensagem');
            $table->boolean('estado');
            $table->unsignedBigInteger('idUser');
            $table->unsignedBigInteger('idJogo');
            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idJogo')->references('id')->on('jogos')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabela TipoProduto (id, tipo, imagem)
        Schema::create('tipoProdutos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->string('imagem')->nullable();
        });

        // Tabela Produto (id, nome, preco, valor, idTipoProduto)
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->integer('preco');
            $table->integer('valor');
            $table->unsignedBigInteger('idTipoProduto');
            $table->foreign('idTipoProduto')->references('id')->on('tipoProdutos')->onDelete('cascade');
        });

        // Tabela Compras (id, idUser, idProduto)
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idUser');
            $table->unsignedBigInteger('idProduto');
            $table->boolean('usado')->default(true);
            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idProduto')->references('id')->on('produtos')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabela TipoMisoes (id, tipo)
        Schema::create('tipoMissoes', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
        });

        // Tabela Missoes (id, tipo, estado, descricao, objetivo, moedas, idTipoMissao)
        Schema::create('missoes', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->boolean('estado');
            $table->text('descricao');
            $table->integer('objetivo');
            $table->integer('moedas');
            $table->unsignedBigInteger('idTipoMissao');
            $table->foreign('idTipoMissao')->references('id')->on('tipoMissoes')->onDelete('cascade');
        });

        // Tabela Users_Missoes (id, idUser, idMissao)
        Schema::create('users_missoes', function (Blueprint $table) {
            $table->id();
            $table->boolean('concluida');
            $table->integer('progresso')->default(0);
            $table->unsignedBigInteger('idUser');
            $table->unsignedBigInteger('idMissao');
            $table->date('data')->nullable();
            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idMissao')->references('id')->on('missoes')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabela LinksExternos (id, nome, url)
        Schema::create('linksExternos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('url');
        });

        // Tabela Curso_LinksExternos (id, idCurso, idLink)
        Schema::create('curso_linksExternos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idCurso');
            $table->unsignedBigInteger('idLink');
            $table->foreign('idCurso')->references('id')->on('cursos')->onDelete('cascade');
            $table->foreign('idLink')->references('id')->on('linksExternos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
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
