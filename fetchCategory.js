function fetchCat(){
    fetch('backendCategory.php?action=fetchCategories')
    .then(res => res.json())
    .then(data => {
        const img = document.getElementById('catImg');
        img.src = data[0].url;
    })
    .catch(err => console.log(err));
}

function createCategoryFromInput() {
    const name = document.getElementById('categoryTitle').value;
    const selectedImg = document.querySelector('.img[data-selected="true"]');
    let imgId = null;

    if (selectedImg) {
        imgId = selectedImg.id;
    }

    createCategory(name, imgId);
}


function createCategory(name, img) {
    if (!name.trim()) {
        showToast('The name of a category cannot be empty', 'warning');
        return;
    }

    const categoryData = {
        name: name,
        img: img
    };

    fetch('backendCategory.php?action=createCategory', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(categoryData)
    })
    .then(response => response.json())
    .then(result => {
        if (result.message === 'Category created successfully') {
            console.log(categoryData);
            showToast('Category created successfully', 'success');
        } else {
            console.error('Error creating category:', result.error);
            showToast(result.error, 'warning');
        }
    })
    .catch(error => {
        console.error('Error creating category:', error);
        showToast('An unexpected error occurred', 'error');
    });
}

