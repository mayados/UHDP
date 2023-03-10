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
      // On sélectionne les inputs (on pourrait cinler le type checkbox, mais nos inputs sont que des checkbox)
      this.form.querySelectorAll('input').forEach(input => {
        input.addEventListener('change', this.loadForm.bind(this))
      })
      // On sélectionne les select du formulaire
      this.form.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', this.loadForm.bind(this))
      })
      // On sélectionne les input Texte du formulaire
      this.form.querySelectorAll('input[type = text]').forEach(select => {
        select.addEventListener('input', this.loadForm.bind(this))
      })
      // Pagination lors d'un clic
      // this.pagination.querySelectorAll('a').forEach(a => {
      //   a.addEventListener("click", e => {
      //     e.preventDefault()
      //     this.loadUrl(a.getAttribute('href'))
      //     console.log('click pagination')
      //   })
      // })

      // Quand on clique sur la pagination, si l'évènement a lieu sur une balise a, on effectue la requête en passant en url l'attribute du lien
        this.pagination.addEventListener("click", e => {
          if(e.target.tagName === 'a'){
            e.preventDefault()
            // console.log('click pagination')
            this.loadUrl(a.getAttribute('href'))
                        
          }
        })

    }

    async loadForm(){
      const data = new FormData(this.form)
      // On crée une nouvelle URL à partir de ce qu'on retrouve dans le formulaire
      // Si cet attribut n'existe pas, on récupère l'url courante
      const url = new URL(this.form.getAttribute('action')|| window.location.href) 
      console.log(url)
      const params = new URLSearchParams()
      data.forEach((value, key) => {
        params.append(key, value)
      })
      return this.loadUrl(url.pathname + '?' + params.toString())
     
    }

    // On convertit en AJAX
    async loadUrl(url){
      const ajaxUrl = url + '&ajax=1'
      const response = await fetch(ajaxUrl, {
        headers: {
          //  Permet de différencier une requête classique d'une requête AJAX
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      // On vérifie si la requête a un statut situé entre 200 et 300, si c'est le cas tout se passe bien
      if(response.status >= 200 && response.status < 300){
        const data = await response.json()
        this.content.innerHTML = data.content
        this.pagination.innerHTML = data.pagination    
        // Pour que l'utilisateur puisse retourner directement en arrière et n'ai pas à repasser par tous les filtres
        history.replaceState({}, '', url)

        // console.log(data)
      }else{
        console.error(response)
      }
    }

}