// var authorSearchUrl = "https://library.kaasoft.pro/author/search";
// $("#authors").select2({
//   ajax: {
//     url: authorSearchUrl,
//     dataType: "json",
//     type: "POST",
//     data: function (params) {
//       return {
//         searchText: params.term,
//       };
//     },
//     processResults: function (data, params) {
//       if (data.redirect) {
//         window.location.href = data.redirect;
//       } else {
//         if (data.error) {
//           app.notification("error", data.error);
//         } else {
//           return {
//             results: $.map(data, function (item) {
//               if (item.firstName && item.lastName) {
//                 var text = item.firstName + " " + item.lastName;
//               } else if (item.firstName) {
//                 text = item.firstName;
//               } else if (item.lastName) {
//                 text = item.lastName;
//               }
//               return {
//                 text: text,
//                 id: item.id,
//                 term: params.term,
//               };
//             }),
//           };
//         }
//       }
//     },
//     cache: false,
//   },
//   templateResult: function (item) {
//     if (item.loading) {
//       return item.text;
//     }
//     return app.markMatch(item.text, item.term);
//   },
//   minimumInputLength: 2,
// });
