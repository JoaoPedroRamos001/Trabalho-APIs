<!--inclui a cabeça do site que tem elementos HTML-->
<?php include 'includes/cabecalho.php';

$resultado = '';
//verifica se foi feita uma busca
if (isset($_GET['livro']) && !empty($_GET['livro'])) {
    $livro = urlencode(trim($_GET['livro']));
    $url = "https://www.googleapis.com/books/v1/volumes?q=" . $livro;

    //faz a requisição à API
    $response = @file_get_contents($url);

    if ($response !== false) {
        $data = json_decode($response, true);
        if (isset($data['items'][0])) {
            //extrai as informações do livro
            $livroInfo = $data['items'][0]['volumeInfo'];
            $titulo = $livroInfo['title'] ?? 'Título não disponível';
            $autor = isset($livroInfo['authors']) ? implode(', ', $livroInfo['authors']) : 'Autor não disponível';
            $ano = isset($livroInfo['publishedDate']) ? date('Y', strtotime($livroInfo['publishedDate'])) : 'Ano não disponível';
            $capa = isset($livroInfo['imageLinks']['thumbnail']) ? str_replace('http:', 'https:', $livroInfo['imageLinks']['thumbnail']) : 'caminho/para/imagem/padrao.jpg';
            $resultado = "
                <h2>{$titulo}</h2>
                <img src='{$capa}' alt='Capa do livro' class='capa-livro' onclick='openFullscreen(this)'>
                <p><strong>Autor:</strong> {$autor}</p>
                <p><strong>Ano de Publicação:</strong> {$ano}</p>
            ";
        } else {
            $resultado = "<p>Livro não encontrado.</p>";
        }
    } else {
        $resultado = "<p>Erro ao buscar informações do livro.</p>";
    }
}
?>

<div class="container">
    <h1>APIs de Livros</h1>

    <div class="search-container">
        <!--div para exibir mensagens de erro-->
        <div id="error-message" class="error-message"></div>
        
        <!--formulário de busca-->
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

        <!--exibe o resultado da busca-->
        <?php if ($resultado): ?>
            <div class="card-container">
                <div class="card resultado-card">
                    <div class="card-content">
                        <?php echo $resultado; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!--rodape comum do site -->
<?php include 'includes/rodape.php'; ?>