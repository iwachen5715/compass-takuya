$(function () {
  // 検索条件のトグル
  $('.search_conditions').click(function () {
    $('.search_conditions_inner').slideToggle();
    $(this).toggleClass('is-open'); // クラスを切り替え
  });

  // 教科編集ボタンのトグル
  $('.subject_edit_btn').click(function () {
    $('.subject_inner').slideToggle();
    $(this).toggleClass('is-open'); // クラスを切り替え
  });
});


// document.addEventListener('DOMContentLoaded', function () {
//   const editButton = document.querySelector('.subject_edit_btn');
//   const subjectInner = document.querySelector('.subject_inner');

//   // 初期設定でスライドを非表示
//   subjectInner.style.display = 'none';

//   editButton.addEventListener('click', function () {
//     // スライドの開閉
//     if (subjectInner.style.display === 'none') {
//       subjectInner.style.display = 'block';
//       editButton.classList.add('open');
//     } else {
//       subjectInner.style.display = 'none';
//       editButton.classList.remove('open');
//     }
//   });
// });
