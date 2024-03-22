<form id="categoryForm">
<h1>Création de Catégorie</h1>
  <div class="mb-3">
    <label for="taskTitle" class="form-label">Titre de la Catégorie</label>
    <input type="text" class="form-control" id="categoryTitle" required>
  </div>
  <div class="mb-3">
  <div class="img-container">
    <div class="row">
    </div>
  </div>
  </label>
  <button type="button" class="btn btn-primary" onclick="createCategoryFromInput()">Créer Catégorie</button>
</form>
<script>
function popImg() {
    const imgContainer = document.querySelector('.img-container .row');
    
    fetch('public/assets/img/')
        .then(response => response.text())
        .then(data => {
            // Extract image filenames from directory listing
            const filenames = data.match(/href="([^"]+)/g)
                .map(match => match.replace('href="', ''));

            // Filter out directory paths and keep only image filenames
            const imageFilenames = filenames.filter(filename => {
                return /\.(jpg|jpeg|png|gif)$/i.test(filename);
            });

            // Create image elements and append to container
            imageFilenames.forEach(filename => {
                const img = document.createElement('img');
                img.src = 'public/assets/img/' + filename;
                img.alt = filename;
                const id = filename.replace(/\.[^/.]+$/, ''); // Extract filename without extension as id
                img.className = 'img';
                img.id = id;
                img.addEventListener('click', selectImg);

                const col = document.createElement('div');
                col.className = 'col-md-2 mb-3';
                col.appendChild(img);

                imgContainer.appendChild(col);
            });
        })
        .catch(error => console.error('Error loading images:', error));
}

function selectImg(event) {
    const allImages = document.querySelectorAll('.img');
    allImages.forEach(img => {
        img.style.border = 'none';
        img.style.width = '50px';
        img.removeAttribute('data-selected');

        

    });
    const selectedImg = event.target;
    selectedImg.style.border = '4px solid rgb(147, 147, 236)';
    selectedImg.style.borderRadius = '10px';
    selectedImg.style.padding = '5px';
    selectedImg.style.margin = '5px';
    selectedImg.style.width = '70px';
    selectedImg.setAttribute('data-selected', 'true');
    console.log('border added');
}

document.addEventListener('DOMContentLoaded', popImg);

</script>