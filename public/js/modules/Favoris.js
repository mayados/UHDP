
export default class Favoris {

    /**
     * @param {HTMLElement|null} favorisElements 
     */
      constructor(favorisElements){
        this.favorisElements = favorisElements;

          if(favorisElements){
            this.init()
          }
      }
  
      init(){
        //  On enlève la logique de base 
        this.favorisElements.map(element => {
            element.addEventListener('click', this.onClick)
        }) 
      }

      onClick(event){
        
        event.preventDefault();
        const url = new URL(this.href|| window.location.href);
        // Avant la promesse, on sélectionne l'icone actuelle
        console.log(this)
        const icone = this.querySelector('i');  
        console.log(url)
        fetch(url.pathname + "?", {
            headers: {
            'X-Requested-With': 'XMLHttpRequest'
            },
            // method: 'GET'
        })
            .then(response => response.json())
            .then(response => {

              // On vérifie dans quel cas on est 
              if(icone.classList.contains('unlikedStar')){
                console.log("je met en favoris")
                icone.classList.replace('unlikedStar','likedStar')
              }else{
                console.log("j'enlève des favoris")
                 icone.classList.replace('likedStar','unlikedStar')
              }
                // Reste à catch les exceptions
            }).catch(e => alert(e));
      }

  }