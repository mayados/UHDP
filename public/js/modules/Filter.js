/**
 * @property {HTMLElement} pagination
 * @property {HTMLElement} content
 * @property {HTMLFormElement} form
 */
export default class Filter {

  /**
   * @param {HTMLElement|null} element 
   */
    constructor(element){
        if(element == null){
          return  
        }
        this.pagination = element.querySelector('.js-filter-pagination')
        this.content = element.querySelector('.js-filter-content')
        this.form = element.querySelector('.js-filter-form')
        this.bindEvents()
    }

    bindEvents(){
      // On sélectionne les inputs de type checkbox
      this.form.querySelectorAll('input[type = checkbox]').forEach(input => {
        
        input.addEventListener('change', this.loadForm.bind(this))
      })
      //On sélectionne les select du formulaire
      this.form.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', this.loadForm.bind(this))
      })
      // On sélectionne les input de type text
      this.form.querySelectorAll('input[type = text]').forEach(select => {
        select.addEventListener('input', this.loadForm.bind(this))
      })
    }

    // function asynchrone
    async loadForm(){

      const data = new FormData(this.form)
      // On crée une nouvelle URL à partir de l'url courante
      const url = new URL(window.location.href) 
      const params = new URLSearchParams()
    
      data.forEach((value, key) => {
          params.append(key, value)          
      })
     
      // On convertit en AJAX
      fetch(url.pathname + '?' + params.toString(), {
        headers: {
          //  Permet de différencier une requête classique d'une requête AJAX
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      // Lorsque la première promesse (provenant de fetch) aboutit, elle nous donne une réponse (response) que l'on traite en JSON
      .then(response => response.json())
      // Lorsque la promesse provenant de .json aboutit, on récupère ce qui a été traité par le JSON
      .then(data => {
        // On remplace le contenu
        this.content.innerHTML = data.content
        this.pagination.innerHTML = data.pagination    
         // mettre à jour l'url
        history.pushState({},null, url.pathname + "?" + params.toString());
      })
      .catch(e => alert(e));

    }

}    
