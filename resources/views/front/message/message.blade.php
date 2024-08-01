<!DOCTYPE html>

<html
  lang="en"
  class="light-style"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Message - Fotoin</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.5/dist/sweetalert2.min.css">

    <!-- Page CSS -->

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-chat.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper">
      <div class="layout-container">

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="d-flex align-items-center vh-100">
              <div class="container-xxl flex-grow-1 container-p-y">
                <div class="app-chat card overflow-hidden">
                  <div class="row g-0">
                    <!-- Sidebar Left -->
                    <div class="col app-chat-sidebar-left app-sidebar overflow-hidden" id="app-chat-sidebar-left">
                      <div
                        class="chat-sidebar-left-user sidebar-header d-flex flex-column justify-content-center align-items-center flex-wrap px-4 pt-5">
                        <div class="avatar avatar-xl avatar-online">
                          <img src="{{ auth()->user()->profile_image ? asset(auth()->user()->profile_image) : 'https://caspertopup.com/images/avatars/default.jpg' }}" alt="Avatar" class="rounded-circle" />
                        </div>
                        <h5 class="mt-2 mb-0">{{ auth()->user()->username }}</h5>
                        <small>{{ auth()->user()->role }}</small>
                        <i
                          class="ti ti-x ti-sm cursor-pointer close-sidebar"
                          data-bs-toggle="sidebar"
                          data-overlay
                          data-target="#app-chat-sidebar-left"></i>
                      </div>
                    </div>
                    <!-- /Sidebar Left-->

                    <!-- Chat & Contacts -->
                    <div
                      class="col app-chat-contacts app-sidebar flex-grow-0 overflow-hidden border-end"
                      id="app-chat-contacts">
                      <div class="sidebar-header">
                        <div class="p-1">
                          <h5 class="m-0 p-0">{{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }}</h5>
                        </div>
                        <i
                          class="ti ti-x cursor-pointer d-lg-none d-block position-absolute mt-2 me-1 top-0 end-0"
                          data-overlay
                          data-bs-toggle="sidebar"
                          data-target="#app-chat-contacts"></i>
                      </div>
                      <hr class="container-m-nx m-0" />
                      <div class="sidebar-body">
                        <div class="chat-contact-list-item-title">
                          <h5 class="text-primary mb-0 px-4 pt-3 pb-2">Chats</h5>
                        </div>
                        <!-- Chats -->
                        <ul class="list-unstyled chat-contact-list" id="chat-list">
                          @forelse ($getChatUsers as $message)
                              @php
                                  $unseenCount = \App\Models\Message::unseenCount($message->id);
                              @endphp
                              <li class="chat-contact-list-item" data-user-id="{{ $message->id }}">
                                  <a class="d-flex align-items-center">
                                      <div class="flex-shrink-0 avatar avatar-online">
                                          <img src="{{ url('').'/storage/'.$message->profile_image }}" id="img-{{ $message->id }}" alt="Avatar" class="rounded-circle" />
                                      </div>
                                      <h6 class="d-none" id="role">{{ $message->role }}</h6>
                                      <div class="chat-contact-info flex-grow-1 ms-2">
                                          <h6 class="chat-contact-name text-truncate m-0">{{ $message->username }}</h6>
                                          <p class="chat-contact-status text-muted text-truncate mb-0">
                                              {{ $message->latest_message }}
                                          </p>
                                      </div>
                                      @if ($unseenCount > 0)
                                          <div class="badge bg-label-danger rounded-pill ms-auto">{{ $unseenCount }}</div>
                                      @endif
                                  </a>
                              </li>
                          @empty
                              <li class="chat-contact-list-item chat-list-item-0">
                                  <h6 class="text-muted mb-0">No Chats Found</h6>
                              </li>
                          @endforelse
                      </ul>
                      </div>
                    </div>
                    <!-- /Chat contacts -->

                    <!-- Chat History -->
                    <div class="col app-chat-history bg-body">
                      <div class="chat-history-wrapper">
                        <div class="chat-history-header border-bottom">
                          <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex overflow-hidden align-items-center">
                              <i class="ti ti-menu-2 ti-sm cursor-pointer d-lg-none d-block me-2" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-contacts"></i>
                              <div class="flex-shrink-0 avatar">
                                <img src="../../assets/img/avatars/2.png" id="img-user" alt="Avatar" class="rounded-circle d-none" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-right" />
                              </div>
                              <div class="chat-contact-info flex-grow-1 ms-2">
                                <h6 class="m-0" id="text-username"></h6>
                                <small class="user-status text-muted" id="text-role"></small>
                              </div>
                            </div>
                            <div class="d-flex align-items-center">
                              <div class="dropdown d-flex align-self-center">
                                 <button class="btn p-0" type="button" id="chat-header-actions" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                 </button>
                                 <div class="dropdown-menu dropdown-menu-end" aria-labelledby="chat-header-actions">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="reportUser()">Laporkan</a>
                                 </div>
                              </div>
                           </div>                           
                          </div>
                          </div>
                          <div class="chat-history-body bg-body" id="chat-history">
                          </div>
                          <div class="chat-history-footer shadow-sm">
                            <form class="form-send-message d-flex justify-content-between align-items-center">
                              @csrf
                              <input name="to_id" id="to-id" type="hidden">
                          
                              <input name="body" class="form-control message-input border-0 me-3 shadow-none"
                                    placeholder="Type your message here" />
                              <div class="message-actions d-flex align-items-center">
                                  <button class="btn btn-primary d-flex send-msg-btn">
                                      <i class="ti ti-send me-md-1 me-0"></i>
                                      <span class="align-middle d-md-inline-block d-none">Send</span>
                                  </button>
                              </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!-- /Chat History -->

                    <!-- Sidebar Right -->
                    <div class="col app-chat-sidebar-right app-sidebar overflow-hidden" id="app-chat-sidebar-right">
                      <div
                        class="sidebar-header d-flex flex-column justify-content-center align-items-center flex-wrap px-4 pt-5">
                        <div class="avatar avatar-xl avatar-online">
                          <img src="../../assets/img/avatars/2.png" alt="Avatar" class="rounded-circle" />
                        </div>
                        <h6 class="mt-2 mb-0"></h6>
                        <span id="text-role-2"></span>
                        <i
                          class="ti ti-x ti-sm cursor-pointer close-sidebar d-block"
                          data-bs-toggle="sidebar"
                          data-overlay
                          data-target="#app-chat-sidebar-right"></i>
                      </div>
                      <div class="sidebar-body px-4 pb-4">
                        <div class="my-4">
                        </div>
                      </div>
                    </div>
                    <!-- /Sidebar Right -->

                    <div class="app-overlay"></div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>

      <!-- Drag Target Area To SlideIn Menu On Small Screens -->
      <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>

    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/app-chat.js') }}"></script>

    <script>
      $(document).ready(function() {
          var currentUserId = null;
          var chatInterval = null;

          function loadChatHistory(userId) {
              $.ajax({
                  url: '/message/' + userId,
                  type: 'GET',
                  dataType: 'json',
                  success: function(response) {
                      if (!response.status) {
                        window.location.href = '{{ route('view_message') }}';
                      } else if  (response.status) {
                        $('#chat-history').html(response.html);
                        updateUserInfo(response.userData);
                      }
                  },
                  error: function(xhr, status, error) {
                    window.location.href = '{{ route('view_message') }}';
                  }
              });
          }

          function getQueryParams() {
              var params = {};
              var queryString = window.location.search.substring(1);
              var regex = /([^&=]+)=([^&]*)/g;
              var m;
              while (m = regex.exec(queryString)) {
                  params[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
              }
              return params;
          }

          function updateUserInfo(userData) {
              $('#app-chat-sidebar-right img').attr('src', userData.profile_image);
              $('#app-chat-sidebar-right h6').text(userData.username);
              $('#img-user').attr('src', userData.profile_image);
              $('#img-user').removeClass('d-none');
              $('#text-username').text(userData.username);
              $('#text-role').text(userData.role);
              $('#text-role-2').text(userData.role);
          }

          var queryParams = getQueryParams();
          if (queryParams.id && queryParams.text) {
              var userId = queryParams.id;
              var text = queryParams.text;

              loadChatHistory(userId);

              if (chatInterval !== null) {
                  clearInterval(chatInterval);
              }

              loadChatHistory(userId);
              chatInterval = setInterval(function() {
                  loadChatHistory(userId);
              }, 1000);

              $('#to-id').val(userId);
              $('.message-input').val(text);

              $('.chat-contact-list-item[data-user-id="' + userId + '"]').click();
          }

          $('.chat-contact-list-item').click(function(e) {
              e.preventDefault();

              var userId = $(this).data('user-id');
              var profileImage = $(this).find('img').attr('src');
              var username = $(this).find('.chat-contact-name').text();
              var role = $(this).find('#role').text();

              $('#to-id').val(userId);
              currentUserId = userId;

              if (chatInterval !== null) {
                  clearInterval(chatInterval);
              }

              loadChatHistory(userId);
              chatInterval = setInterval(function() {
                  loadChatHistory(userId);
              }, 1000);

              $('#app-chat-sidebar-right img').attr('src', profileImage);
              $('#app-chat-sidebar-right h6').text(username);
              $('#img-user').attr('src', profileImage);
              $('#img-user').removeClass('d-none');
              $('#text-username').text(username);
              $('#text-role').text(role);
              $('#text-role-2').text(role);
          });


          $('.send-msg-btn').click(function(e) {
              e.preventDefault();

              var message = $('.message-input').val().trim();
              if (message === '') {
                  return;
              }

              var formData = new FormData($('.form-send-message')[0]);

              $.ajax({
                  url: '{{ route('message_send') }}',
                  method: 'POST',
                  data: formData,
                  processData: false,
                  contentType: false,
                  success: function(response) {
                      $('.message-input').val('');
                      if(!response.status){
                        toastr.error(response.message,'Oops!');
                      }
                  },
                  error: function(xhr, status, error) {
                      console.error(xhr.responseText);
                  }
              });
          });
      });

      function reportUser() {
      Swal.fire({
          title: 'Laporkan Pengguna',
          html: `
            <textarea id="reportNote" class="swal2-textarea" placeholder="Tulis alasan laporan di sini..."></textarea>
            <input type="file" id="reportProff" class="swal2-file" accept="image/*">
          `,
          showCancelButton: true,
          confirmButtonText: 'Laporkan',
          showLoaderOnConfirm: true,
          preConfirm: () => {
            const note = Swal.getPopup().querySelector('#reportNote').value;
            const proff = Swal.getPopup().querySelector('#reportProff').files[0];
            const reported = document.getElementById('to-id').value;

            if (!note) {
                Swal.showValidationMessage('Catatan tidak boleh kosong');
                return;
            }

            if (!proff) {
                Swal.showValidationMessage('Bukti tidak boleh kosong');
                return;
            }

            const formData = new FormData();
            formData.append('reporter_id', {{ auth()->user()->id }});
            formData.append('reported_id', reported);
            formData.append('note', note);
            formData.append('proff', proff);

            return fetch('{{ route('report_user') }}', {
                method: 'POST',
                headers: {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            }).then(response => {
                if (!response.ok) {
                  return response.json().then(errorData => {
                      throw new Error(JSON.stringify(errorData));
                  });
                }
                return response.json();
            }).catch(error => {
                let errorMessage = 'Request failed';
                try {
                  const errorData = JSON.parse(error.message);
                  if (errorData.errors) {
                      errorMessage = Object.values(errorData.errors).flat().join(', ');
                  }
                } catch (e) {
                }
                Swal.showValidationMessage(errorMessage);
            });
          },
          allowOutsideClick: () => !Swal.isLoading()
      }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire({
                title: 'Dilaporkan!',
                text: 'Laporan Anda telah dikirim.',
                icon: 'success'
            });
          }
      });
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </body>
</html>
