document.querySelector('#btn_sign').addEventListener('click', function () {
    document.querySelector('#signup').style.display = 'block';
    document.querySelector('#login').style.display = 'none';
    document.querySelector('.container').style.paddingBottom = '0%';
    document.querySelector('.tab-0').classList.remove('active');
    document.querySelector('.tab-0').classList.add('active');
    document.querySelector('.tab-1').classList.remove('active');
});
document.querySelector('#btn_login').addEventListener('click', function () {
    document.querySelector('#login').style.display = 'block';
    document.querySelector('#signup').style.display = 'none';
    document.querySelector('.container').style.paddingBottom = '15%';
    document.querySelector('.tab-1').classList.remove('active');
    document.querySelector('.tab-0').classList.remove('active');
    document.querySelector('.tab-1').classList.add('active');
});
