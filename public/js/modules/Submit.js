/**
 * @property {HTMLElement} content
 * @property {HTMLFormElement} form
 */
export default class Submit {

    /**
     * @param {HTMLElement|null} element 
     */
      constructor(element){
          if(element == null){
            return  
          }
          this.content = element.querySelector('.js-auto-refresh-content')
              // console.log(this.content)          
          this.form = element.querySelector('.js-submit-form')
        
          // console.log(this.form)
          this.bindEvents()
      }
      
  
      bindEvents(){
          const textareaValue = CKEDITOR.instances['condoleance_texte'];
        
          // const ckField = document.querySelector(".cke_inner")   
          // console.log(ckField)
        this.form.addEventListener('submit', e => {
            e.preventDefault();
          // console.log(ckField.innerHTML)
          console.log(textareaValue)  
            const data = new FormData(this.form)
            // On crée une nouvelle URL à partir de l'url courante
            const url = new URL(window.location.href) 
            const params = new URLSearchParams()
          
            data.forEach((value, key) => {
              // console.log(value)
                params.append(key, value)          
            })
            // console.log('je n ai plus de defaut')
          // console.log(new FormData(e.target))
            fetch(url.pathname + '?' + params.toString(), {
                headers: {
                  //  Permet de différencier une requête classique d'une requête AJAX
                  // 'X-Requested-With': 'XMLHttpRequest',

                },
                // body: new FormData(e.target),
                method: 'POST',
            })
            .then(response => response.json())
            // Lorsque la promesse provenant de .json aboutit, on récupère ce qui a été traité par le JSON
            .then(data => {
                // this.content.innerHTML = data.content
              console.log(data)
            })
            .catch(e => alert(e));
        })


      }
  
    //   // function asynchrone
    //   async loadForm(){
  
    //     const data = new FormData(this.form)
    //     // On crée une nouvelle URL à partir de l'url courante
    //     const url = new URL(window.location.href) 
    //     const params = new URLSearchParams()
      
    //     data.forEach((value, key) => {
    //         params.append(key, value)          
    //     })
       
    //     // On convertit en AJAX
    //     fetch(url.pathname + '?' + params.toString(), {
    //       headers: {
    //         //  Permet de différencier une requête classique d'une requête AJAX
    //         'X-Requested-With': 'XMLHttpRequest'
    //       }
    //     })
    //     // Lorsque la première promesse (provenant de fetch) aboutit, elle nous donne une réponse (response) que l'on traite en JSON
    //     .then(response => response.json())
    //     // Lorsque la promesse provenant de .json aboutit, on récupère ce qui a été traité par le JSON
    //     .then(data => {
    //       // On remplace le contenu
    //       this.content.innerHTML = data.content
    //       this.pagination.innerHTML = data.pagination    
    //        // mettre à jour l'url
    //       history.pushState({},null, url.pathname + "?" + params.toString());
    //     })
    //     .catch(e => alert(e));
  
    //   }
  
  }    
  