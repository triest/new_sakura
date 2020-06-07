import CKEditor5 from '@ckeditor/ckeditor5-build-classic';
import CKEditor5_ru from '@ckeditor/ckeditor5-build-classic/build/translations/ru';

CKEditor5.create(document.querySelector('.ckeditor'), {
    language: 'ru',
}).catch(error => {
    console.error(error);
});
