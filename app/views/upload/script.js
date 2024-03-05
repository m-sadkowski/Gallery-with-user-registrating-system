function openLightbox(image) 
    {
    document.getElementById('lightbox-image').src = image;
    document.getElementById('lightbox').style.display = 'block';
    }
function closeLightbox() 
{
    document.getElementById('lightbox').style.display = 'none';
}
