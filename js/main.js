'use strict';

$(function() { // Le code sera exécuté lorsque l'arbre html est chargé (jQuery utilisé)

  /**
   * Sur toutes les pages : Apparition et disparition du message Flash
   * jQuery utilisé
   */
  $('.flashMessage').fadeIn(200).delay(1000).fadeOut(750);



  /**
   * Page ADMIN : Ajout et édition d'une réalisation, partie "images associées"
   * Écouteur d'évènement lors du click sur une image OU du click sur le bouton "définir comme image principale"
   * JavaScript brut utilisé, pour changer de jQuerry..!
   */
  var image = document.querySelectorAll('.realisation-edit .images-wrapper p');
  for (var i = 0; i < image.length; i++) {
    image[i].addEventListener('mousedown', onImageClicked);
    // -> Fonction onImageClicked définie dans le fichier "events.js"
  }


  /**
   * Page PUBLIC : Réalisation
   * Affichage du Slider "détail de réalisation"
   * jQuery utilisé
   */
  $('.section-portfolio .section-portfolio-wrapper figure').on('click', onRealisationClicked);

  /**
   * Page PUBLIC : Réalisation
   * Fermeture du Slider "détail de réalisation"
   * jQuery utilisé
   */
  $('#portfolio-focus-close').on('click', function() {
    $('.section-portfolio-focus').fadeOut(400);
  });

  /**
   * Page PUBLIC : Réalisation
   * Bouton défilement droit/gauche du Slider "détail de réalisation"
   * jQuery utilisé
   */
  $('#portfolio-focus-right').on('click', onSliderRightClicked);
  $('#portfolio-focus-left').on('click', onSliderLeftClicked);




});