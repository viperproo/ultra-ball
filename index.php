<?php
  function PageContent(){
?>

<section class="wrapper">
  <div class="image-div">
    <img src="Files/Images/Ultra_Ball.png" alt="Logo">
  </div>
</section>

<article class="wrapper">
  <h1 class="title">Witaj na <?php echo PageName() ?>, polskiej stronie poświęconej tematyce gier Pokemon !</h1>
  <p>Znajdziesz tutaj wszystkie najważniejsze informacje na temat świata gier Pokemon</p>
</article>

<article class="wrapper">
  <p class="description">Na chwile obecną w bazie strony znajdują się Pokemony do 5 generacji włącznie</p>
</article>


<?php
  }
	require_once "PHP/page-body.php";
?>