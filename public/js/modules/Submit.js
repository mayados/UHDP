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
          this.form = element.querySelector('.js-submit-form')
          this.likes = element.querySelector('.js-refresh-like')
          console.log(this.likes)
          this.bindEvents()
      }
      
  
      bindEvents(){
     
        this.form.addEventListener('submit', e => {
            e.preventDefault();
          let instanceName = ""
          let instance = ""
          let textareaValue =""
          for(var i in CKEDITOR.instances){
            instance = CKEDITOR.instances[i]
            instanceName = CKEDITOR.instances[i].name
            textareaValue = CKEDITOR.instances[i].getData();

          }
   
            instance.updateElement();
          // CKEDITOR.replace('condoleance_texte')
            const data = new FormData(this.form)
            data.append(instanceName,textareaValue)

            // On crée une nouvelle URL à partir de l'url courante
            const url = new URL(window.location.href) 
            const params = new URLSearchParams()   

            data.forEach((value, key) => {
              console.log(key,value)
                params.append(key, value)          
            })

            fetch(url, {
                headers: {
                  //  Permet de différencier une requête classique d'une requête AJAX
                  'X-Requested-With': 'XMLHttpRequest',

                },
                // data : data,
                body: data,
                method: 'POST',
            })
            // .then(response => response.json())
            // Lorsque la promesse provenant de .json aboutit, on récupère ce qui a été traité par le JSON
            .then(async (response) => {
             console.log(response)
              const data = await response.json();
              // console.log(data)
              // this.content.innerHTML = data.content
              // this.likes.innerHTML = data.likes
              instance.setData("")
              // console.log(data.content) 
            })
            .catch(e => alert(e));
        })
      }
  
  }    
  