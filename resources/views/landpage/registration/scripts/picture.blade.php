   <script>
       function previewPhoto(event) {
           const input = event.target;
           const preview = document.getElementById("foto_siswa_preview");

           if (input.files && input.files[0]) {
               const reader = new FileReader();

               reader.onload = function(e) {
                   const img = new Image();
                   img.src = e.target.result;

                   img.onload = function() {
                       const canvas = document.createElement("canvas");
                       const ctx = canvas.getContext("2d");

                       // Set ukuran canvas ke 200 x 250
                       const canvasWidth = 200;
                       const canvasHeight = 250;
                       canvas.width = canvasWidth;
                       canvas.height = canvasHeight;

                       // Hitung rasio gambar dan canvas
                       const imgAspectRatio = img.width / img.height;
                       const canvasAspectRatio = canvasWidth / canvasHeight;

                       let drawWidth, drawHeight;

                       // Menyesuaikan ukuran gambar agar sesuai dengan canvas
                       if (imgAspectRatio > canvasAspectRatio) {
                           drawWidth = canvasWidth;
                           drawHeight = drawWidth / imgAspectRatio;
                       } else {
                           drawHeight = canvasHeight;
                           drawWidth = drawHeight * imgAspectRatio;
                       }

                       // Hitung posisi untuk memusatkan gambar
                       const offsetX = (canvasWidth - drawWidth) / 2;
                       const offsetY = (canvasHeight - drawHeight) / 2;

                       // Gambar ulang dengan proporsi yang benar
                       ctx.clearRect(0, 0, canvasWidth, canvasHeight); // Menghapus konten sebelumnya
                       ctx.drawImage(img, offsetX, offsetY, drawWidth, drawHeight);
                       preview.src = canvas.toDataURL();
                   };
               };

               reader.readAsDataURL(input.files[0]);
           }
       }
   </script>
