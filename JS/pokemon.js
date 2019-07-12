function PokemonSound() {
  mainContainer.on('click', '.pokemon-sound', function (ev) {
    $(this).next('audio').get(0).play();
  });
}

$(document).ready(PokemonSound);