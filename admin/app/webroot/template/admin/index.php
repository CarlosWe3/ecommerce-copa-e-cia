<?php
/**
 * @author Carlos Augusto Gartner
 * 
 * Layout da administração, as informações de idioma e charset vem do arquivo da "View"
 * 
 * @package View
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $this->_idioma ?>">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_charset ?>" />
		<title>Administração - <?php echo isset($this->_titulo) ? $this->_titulo : '' ?></title>
		<meta name="author" content="WE3 Online" />
		<?php  
			echo html::css(array('reset.css','style.css','layout.css','menu.css'));
			echo html::script('modernizr.js');
		?>
	</head>
	<body>
		<!-- Inicio Header  -->
		<div id="header">
			<h1>Administração | E-commerce</h1>
			<p class="msg-usuario">Seja bem vindo {usuario}, {sair}</p>
		</div>
		<!-- Fim Header -->
		
		<!-- Inicio Menu -->
		<div>
			<ul id="nav">
				<li class="current"><a href="#">Home</a></li>
				<li><a href="#">Catálogo</a>
					<ul>
						<li><a href="#">Produtos</a></li>
						<li><a href="#">Categorias</a></li>
						<li><a href="#">Tags</a></li>
					</ul>					
				</li>
				<li><a href="#">Pedidos</a></li>
				<li><a href="#">Sistema</a>
					<ul>
						<li><a href="#">Configurações</a></li>
						<li><a href="#">Taxas</a></li>
						<li><a href="#">Tags</a></li>
					</ul>	
				</li>
				<li><a href="#">Sair</a></li>
			</ul>
		</div>
		<!-- Fim Menu -->
		
		<!-- Inicio Middle -->
		<div id="middle">
			
		</div>
		<!-- Fim Middle -->
		
		<!-- Inicio Footer -->
		<div id="footer">
			
		</div>
		<!-- Fim Footer -->
		
		<!-- Loder dos javascript embaixo do documento -->

		<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="<?php echo BASE_URL . 'app/webroot/' ?>js/libs/jquery-1.7.1.min.js"><\/script>')</script>
			
		<!-- scripts concatenated and minified via build script -->
		<?php
			echo html::script(array("plugins.js","script.js"));
		?>		
	</body>
</html>
