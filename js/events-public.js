'use strict';
/**
 * Variable globale qui contiendra toutes les images de la réalisation cliquée
 */
var imagesNames = [];


/**
 * Fonction exécutée lors du click sur une réalisation
 * jQuery utilisé
 */
function onRealisationClicked() {
  var id = $(this).data('id').toString();  // récupération de l'ID de la réalisation cliquée
  // mise en forme dans un objet JS (= tableau associatif PHP) pour etre envoyé en AJAX :
  var data = {
    'id' : id
  };

  // requête ajax permettant de récupérer toutes les infos de la réalisation (titre, description, images, etc.)
  $.ajax({
    url: "realisations-ajax.php",
    method: 'GET',
    data: data,
    dataType: "json",
    cache: false,
    success: function(result) {
      /**
       *  Exécuté lors du succès de la requte AJAX
       */
      // Enregistrement en global de la liste des images
      imagesNames = result['images'];
      //Changer le titre :
      $('#portfolio-focus-title').html(result['realisation']['title']);
      // Changer la description :
      $('#portfolio-focus-description').html(result['realisation']['description']);
      // changer l'image principale
      if (result['realisation']['mainImageName'] == "") {
        $('#portfolio-focus-slider img').attr('src', 'img/portfolio/img-not-available.png');
        $('#portfolio-focus-slider img').attr('data-nb', '0');
      } else {
        $('#portfolio-focus-slider img').attr('src','img/portfolio/'+result['realisation']['mainImageName']);
        for (var i = 0; i < result['images'].length; i++) {
          if (result['images'][i] == result['realisation']['mainImageName']) {
            $('#portfolio-focus-slider img').attr('data-nb', i);
          }
        }
      }
      $('#portfolio-focus-slider img').attr('alt','Impression d\'écran de la réalisation : '+result['realisation']['title']);
      // changer les catégories
      $('#portfolio-focus-categories p').remove();
      for (var i = 0; i < result['categories'].length; i++) {
        $('#portfolio-focus-categories').append('<p>'+result['categories'][i]+'</p>');
      }
      // Changer le lien vers le site
      $('#portfolio-focus-link a').remove();
      if (result['realisation']['linkToWebsite'] != "") {
        $('#portfolio-focus-link').append('<a href="' + result['realisation']['linkToWebsite'] + '" class="btn" target="_blank">Aller voir ce site web</a>');
      }
      // fadeIn du Slider "détail de réalisation"
      $('.section-portfolio-focus').fadeIn(400);
    }
  });
}

/**
 * Fonction exécutée lors du click sur le bouton de défilement droit du Slider "détail de réalisation"
 * jQuery utilisé
 */
function onSliderRightClicked() {
  // fade out de l'image affichée
  $('#portfolio-focus-slider img').fadeOut(200, function() { // fonction exécutée à la fin de fade out
    // Variables id de la photo
    var idCurrentPic = parseInt($('#portfolio-focus-slider img').attr("data-nb"));
    var idToDisplay = 0;
    // test sur le rang de l'image
    if (idCurrentPic == (imagesNames.length - 1)) { // si on est arrivé à la fin de la liste d'image
      idToDisplay = 0; // on revient au début
    } else { // sinon
      idToDisplay = idCurrentPic + 1; // on incrémente
    }
    // Affichage de la bonne image
    $('#portfolio-focus-slider img').attr('src','img/portfolio/'+imagesNames[idToDisplay]);
    $('#portfolio-focus-slider img').attr('data-nb', idToDisplay);
    // fade in de l'image
    $('#portfolio-focus-slider img').fadeIn(200);
  });
}

/**
 * Fonction exécutée lors du click sur le bouton de défilement gauche du Slider "détail de réalisation"
 * jQuery utilisé
 */
function onSliderLeftClicked() {
  // fade out de l'image affichée
  $('#portfolio-focus-slider img').fadeOut(200, function() { // fonction exécutée à la fin de fade out
    // Variables id de la photo
    var idCurrentPic = parseInt($('#portfolio-focus-slider img').attr("data-nb"));
    var idToDisplay = 0;
    // test sur le rang de l'image
    if (idCurrentPic == 0) { // si on est arrivé au début de la liste d'image
      idToDisplay = (imagesNames.length - 1); // on v à la fin
    } else { // sinon
      idToDisplay = idCurrentPic - 1; // on décrémente
    }
    // Affichage de la bonne image
    $('#portfolio-focus-slider img').attr('src','img/portfolio/'+imagesNames[idToDisplay]);
    $('#portfolio-focus-slider img').attr('data-nb', idToDisplay);
    // fade in de l'image
    $('#portfolio-focus-slider img').fadeIn(200);
  });
}

