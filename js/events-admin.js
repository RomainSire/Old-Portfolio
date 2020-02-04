'use strict';
/**
 * Fonction exécuté lors du click sur une image dans la page d'ajout de réalisations
 * JavaScript brut utilisé
 */
function onImageClicked(event) {
  // Tout d'abord, TEST pour savoir si on a clické seulement sur l'image ou sur le bouton "définir comme image principale"
  if ((event.target).closest('.home-image-btn') == null) {
    /**
     *  On n'a pas cliqué sur le bouton "définir comme image principale"
     * -> on ne fait que sélectionner/désélectionner une nouvelle image
     */
    // Toggle la classe 'selected' à l'image clickée
    this.classList.toggle('selected');
    // Afficher/masquer le bouton 'définir comme photo principale' à l'image clickée
    this.children[2].classList.toggle('hidden');
    // Si l'élément a la classe .selected-and-main, on enlève cette classe
    if (this.classList.contains('selected-and-main')) {
      this.classList.remove('selected-and-main');
      // on enlève aussi la classe .home-image-btn-main du bouton
      this.children[2].classList.remove('home-image-btn-main');
      // on enlève le nom de la photo du champ caché input[name="mainImageName"]
      document.querySelector('.realisation-edit input[name="mainImageName"]').value = "";
    }


  } else {
    /**
     * On a cliqué sur le bouton "définir comme image principale"
     * -> on ne touche pas à la sélection de photos, on sélectionne simplement la photo principale
     */
    // On enlève la classe .selected-and-main de toutes les images et .home-image-btn-main de tous les boutons
    var images = document.querySelectorAll('.realisation-edit .images-wrapper p');
    for (var i = 0; i < images.length; i++) {
      images[i].classList.remove('selected-and-main');
      images[i].children[2].classList.remove('home-image-btn-main');
    }
    // Ajoute la classe .selected-and-main à l'image clickée
    this.classList.add('selected-and-main');
    // Ajoute la classe .home-image-btn-main au bouton
    this.children[2].classList.add('home-image-btn-main');
    // on met le nom de la photo sélectionnée dans le champ caché input[name="mainImageName"]
    var filename = this.getAttribute("data-filename");
    document.querySelector('.realisation-edit input[name="mainImageName"]').value = filename;
  }

}



