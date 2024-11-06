<!--inclui a cabeça comum do site que tem elementos HTML-->
<?php include 'includes/header.php'; ?>

<div class="container">
    <h1>APIs de Livros</h1>

    <div class="search-container">
        <!--div para exibir mensagenm de erro -->
        <div id="error-message" class="error-message" style="display: none;"></div>
        
        <!--formulário de busca -->
        <form method="GET" action="" class="search-form">
            <div class="input-group">
                <input type="text" 
                       name="livro" 
                       id="livroInput" 
                       placeholder="Digite o título do livro..." 
                       value="<?php echo isset($_GET['livro']) ? htmlspecialchars($_GET['livro']) : ''; ?>">
                <button type="submit" id="buscarLivro">Buscar</button>
            </div>
        </form>

        <?php
        //verifica se foi feita uma busca
        if (isset($_GET['livro']) && !empty($_GET['livro'])) {
            $livro = urlencode(trim($_GET['livro']));
            $url = "https://openlibrary.org/search.json?q=" . $livro;

            //faz a requisição à API
            $response = @file_get_contents($url);

            if ($response !== false) {
                $data = json_decode($response, true);
                if (isset($data['docs'][0])) {
                    //extrai as informações do livro
                    $livroInfo = $data['docs'][0];
                    $titulo = $livroInfo['title'] ?? 'Título não disponível';
                    $autor = implode(', ', $livroInfo['author_name'] ?? ['Autor não disponível']);
                    $ano = $livroInfo['first_publish_year'] ?? 'Ano não disponível';
                    ?>
                    
                    <!--exibe as informações do livro -->
                    <div class="card-container">
                        <div class="card resultado-card">
                            <div class="card-content">
                                <h2><?php echo $titulo; ?></h2>
                                <p><strong>Autor:</strong> <?php echo $autor; ?></p>
                                <p><strong>Ano de Publicação:</strong> <?php echo $ano; ?></p>
                            </div>
                        </div>
                    </div>

                    <?php
                } else {
                    //exibe mensagem se o livro não for encontrado
                    echo "<div class='error-message show'>Livro não encontrado.</div>";
                }
            } else {
                //exibe mensagem em caso de erro na requisição
                echo "<div class='error-message show'>Erro ao buscar informações do livro.</div>";
            }
        }
        ?>
    </div>
</div>

<!--inclui o rodape comum do site -->
<?php include 'includes/footer.php'; ?>