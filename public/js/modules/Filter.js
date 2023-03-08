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
      // Faire également un querySelectorAll pour les select
      this.form.querySelectorAll('input').forEach(input => {
        input.addEventListener('change', this.loadForm.bind(this))
      })
    }

    async loadForm(){
      const data = new FormData(this.form)
      // On crée une nouvelle URL à partir de ce qu'on retrouve dans le formulaire
      // Si cet attribut n'existe pas, on récupère l'url courante
      const url = new URL(this.form.getAttribute('action')|| window.location.href) 
      const params = new URLSearchParams()
      data.forEach((value, key) => {
        params.append(key, value)
      })
      return this.loadUrl(url.pathname + '?' + params.toString())
     
    }

    // On convertit en AJAX
    async loadUrl(url){
      const response = await fetch(url, {
        headers: {
          //  Permet de différencier une requête classique d'une requête AJAX
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      // On vérifie si la requête a un statut situé entre 200 et 300, si c'est le cas tout se passe bien
      if(response.status >= 200 && response.status < 300){
        const data = await response.json()
        this.content.innerHTML = data.content
      }else{
        console.error(response)
      }
    }

}