 {{-- Bootstrap --}}
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

 {{-- Bootstrap Icons --}}
 <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

 {{-- AOS CSS --}}
 <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
 {{-- Vendor JS --}}
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

 {{-- PureCounter --}}
 <script src="https://cdn.jsdelivr.net/npm/@srexi/purecounterjs/dist/purecounter_vanilla.js"></script>
 <script>
     new PureCounter();
 </script>
 <style>
     .count-box {
         display: flex;
         align-items: center;
         padding: 20px;
         background: #fff;
         box-shadow: 0px 0 30px rgba(1, 41, 112, 0.08);
         transition: 0.3s;
         border-radius: 8px;
     }

     .count-box i {
         font-size: 40px;
         line-height: 0;
         margin-right: 20px;
         color: #4154f1;
     }

     .count-box span {
         font-size: 36px;
         font-weight: 600;
         display: block;
         color: #012970;
     }

     .count-box p {
         margin: 0;
         font-size: 14px;
     }
 </style>
 <section id="counts" class="counts mt-5">
     <div class="container" data-aos="fade-up">

         <div class="container" data-aos="fade-up">

             <div class="row gy-4">

                 <!-- Siswa -->
                 <div class="col-lg-3 col-md-6">
                     <div class="count-box">
                         <i class="bi bi-person-fill"></i>
                         <div>
                             <span data-purecounter-start="0" data-purecounter-end="1258" data-purecounter-duration="1"
                                 class="purecounter"></span>
                             <p>Siswa</p>
                         </div>
                     </div>
                 </div>

                 <!-- Rombel -->
                 <div class="col-lg-3 col-md-6">
                     <div class="count-box">
                         <i class="bi bi-diagram-3-fill" style="color: #ee6c20;"></i>
                         <div>
                             <span data-purecounter-start="0" data-purecounter-end="40" data-purecounter-duration="1"
                                 class="purecounter"></span>
                             <p>Rombel</p>
                         </div>
                     </div>
                 </div>

                 <!-- Mata Pelajaran -->
                 <div class="col-lg-3 col-md-6">
                     <div class="count-box">
                         <i class="bi bi-book-half" style="color: #15be56;"></i>
                         <div>
                             <span>16+</span>
                             <p>Mata Pelajaran</p>
                         </div>
                     </div>
                 </div>

                 <!-- Guru & Pegawai -->
                 <div class="col-lg-3 col-md-6">
                     <div class="count-box">
                         <i class="bi bi-people-fill" style="color: #bb0852;"></i>
                         <div>
                             <span data-purecounter-start="0" data-purecounter-end="111" data-purecounter-duration="1"
                                 class="purecounter"></span>
                             <p>Guru dan Pegawai</p>
                         </div>
                     </div>
                 </div>

             </div>

         </div>

     </div>
 </section>

 {{-- AOS --}}
 <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
 <script>
     AOS.init();
 </script>
