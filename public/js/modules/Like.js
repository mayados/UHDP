
export default class Like {

    /**
     * @param {HTMLElement|null} likeElements 
     */
      constructor(likeElements){
        this.likeElements = likeElements;

          if(likeElements){
            this.init()
          }
      }
  
      init(){
        //  On enlève la logique de base 
        this.likeElements.map(element => {
            element.addEventListener('click', this.onClick)
        }) 
      }

      onClick(event){
        
        event.preventDefault();
        const url = new URL(this.href|| window.location.href);
        console.log(url)
        fetch(url.pathname + "?", {
            headers: {
            'X-Requested-With': 'XMLHttpRequest'
            },
            // method: 'GET'
        })
            .then(response => response.json())
            .then(json => {
                console.log(this)
                const nb = json.nbLike;
                const span = this.querySelector('span');
                this.dataset.nb = nb;
                span.innerHTML = nb + ' patounes'

                const unLiked = this.querySelector('i.unlikedPaw');
                console.log(unLiked)
                const liked = this.querySelector('i.likedPaw');
                // console.log(liked)
                // // liked.style.color = "magenta";
                // unLiked.style.display = "magenta";
            })
      }

  }