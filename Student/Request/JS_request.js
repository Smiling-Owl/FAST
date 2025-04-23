const images = document.querySelectorAll('.carousel-slide');
let currentIndex = 0;

function showNextImage() {
  images.forEach((img, i) => {
    img.classList.remove('active');
    if (i === currentIndex) {
      img.classList.add('active');
    }
  });

  currentIndex = (currentIndex + 1) % images.length;
}

if (images.length > 0) {
  images[currentIndex].classList.add('active');
  setInterval(showNextImage, 5000);
}

document.querySelectorAll('input, textarea').forEach(input => {
  input.addEventListener('input', () => {
    input.classList.toggle('filled', input.value !== '');
  });

  input.addEventListener('focus', () => {
    input.style.boxShadow = '0 0 5px #3f87a6';
    input.style.borderColor = '#3f87a6';
  });

  input.addEventListener('blur', () => {
    input.style.boxShadow = 'none';
    input.style.borderColor = '#ccc';
  });
});

const form = document.querySelector('form');
form.addEventListener('submit', (e) => {
  e.preventDefault();
  alert('Your tutoring request has been submitted! 🎉');
  form.reset();
});
