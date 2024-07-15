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

    <title>Fullcalendar - Apps | Vuexy - Bootstrap Admin Template</title>

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
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/fullcalendar/fullcalendar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />

    <!-- Page CSS -->

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-calendar.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

        <!-- Layout container -->
        <div class="layout-page">
            

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card app-calendar-wrapper">
                <div class="row g-0">
                  <!-- Calendar & Modal -->
                  <div class="col app-calendar-content">
                    <div class="card shadow-none border-0">
                      <div class="card-body pb-0">
                        <!-- FullCalendar -->
                        <div id="calendar"></div>
                      </div>
                    </div>
                    <div class="app-overlay"></div>
                    <!-- FullCalendar Offcanvas -->
                    <div class="offcanvas offcanvas-end event-sidebar" tabindex="-1" id="addEventSidebar" aria-labelledby="addEventSidebarLabel">
                    </div>
                  </div>
                  <!-- /Calendar & Modal -->
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
    <script src="{{ asset('assets/vendor/libs/fullcalendar/fullcalendar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core/locales/id.js"></script>
    <script>
        let direction = 'ltr';

        if (isRtl) {
            direction = 'rtl';
        }

        document.addEventListener('DOMContentLoaded', function () {
            (function () {
                const calendarEl = document.getElementById('calendar'),
                    addEventSidebar = document.getElementById('addEventSidebar'),
                    appOverlay = document.querySelector('.app-overlay'),
                    calendarsColor = {
                        Booked: 'danger',
                    },
                    offcanvasTitle = document.querySelector('.offcanvas-title'),
                    btnToggleSidebar = document.querySelector('.btn-toggle-sidebar'),
                    btnSubmit = document.querySelector('button[type="submit"]'),
                    btnDeleteEvent = document.querySelector('.btn-delete-event'),
                    btnCancel = document.querySelector('.btn-cancel'),
                    eventTitle = document.querySelector('#eventTitle'),
                    eventStartDate = document.querySelector('#eventStartDate'),
                    eventEndDate = document.querySelector('#eventEndDate'),
                    eventUrl = document.querySelector('#eventURL'),
                    eventLabel = $('#eventLabel'), // ! Using jquery vars due to select2 jQuery dependency
                    eventGuests = $('#eventGuests'), // ! Using jquery vars due to select2 jQuery dependency
                    eventLocation = document.querySelector('#eventLocation'),
                    eventDescription = document.querySelector('#eventDescription'),
                    allDaySwitch = document.querySelector('.allDay-switch'),
                    inlineCalendar = document.querySelector('.inline-calendar');

                let eventToUpdate,
                    currentEvents = events, // Assign app-calendar-events.js file events (assume events from API) to currentEvents (browser store/object) to manage and update calendar events
                    inlineCalInstance;

                // Init event Offcanvas
                const bsAddEventSidebar = new bootstrap.Offcanvas(addEventSidebar);

                //! TODO: Update Event label and guest code to JS once select removes jQuery dependency
                // Event Label (select2)
                if (eventLabel.length) {
                    function renderBadges(option) {
                        if (!option.id) {
                            return option.text;
                        }
                        var $badge =
                            "<span class='badge badge-dot bg-" + $(option.element).data('label') + " me-2'> " + '</span>' + option.text;

                        return $badge;
                    }
                    eventLabel.wrap('<div class="position-relative"></div>').select2({
                        placeholder: 'Select value',
                        dropdownParent: eventLabel.parent(),
                        templateResult: renderBadges,
                        templateSelection: renderBadges,
                        minimumResultsForSearch: -1,
                        escapeMarkup: function (es) {
                            return es;
                        }
                    });
                }

                // Modify sidebar toggler
                function modifyToggler() {
                    const fcSidebarToggleButton = document.querySelector('.fc-sidebarToggle-button');
                    fcSidebarToggleButton.classList.remove('fc-button-primary');
                    fcSidebarToggleButton.classList.add('d-none', 'd-inline-block', 'ps-0');
                    while (fcSidebarToggleButton.firstChild) {
                        fcSidebarToggleButton.firstChild.remove();
                    }
                }

                // --------------------------------------------------------------------------------------------------
                // AXIOS: fetchEvents
                // * This will be called by fullCalendar to fetch events. Also this can be used to refetch events.
                // --------------------------------------------------------------------------------------------------
                function fetchEvents(info, successCallback) {
                    successCallback(currentEvents);
                }

                // Init FullCalendar
                // ------------------------------------------------
                let calendar = new Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: fetchEvents,
                    plugins: [dayGridPlugin, interactionPlugin, listPlugin, timegridPlugin],
                    editable: false,
                    dragScroll: false,
                    dayMaxEvents: 2,
                    eventResizableFromStart: true,
                    customButtons: {
                        sidebarToggle: {
                            text: 'Sidebar'
                        }
                    },
                    headerToolbar: {
                        start: 'sidebarToggle, prev,next, title',
                        center: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth',
                        end: '',
                    },
                    locale: 'id', 
                    direction: direction,
                    initialDate: new Date(),
                    navLinks: true, // can click day/week names to navigate views
                    eventClassNames: function ({ event: calendarEvent }) {
                        const colorName = calendarsColor[calendarEvent._def.extendedProps.calendar];
                        // Background Color
                        return ['fc-event-' + colorName];
                    },
                    datesSet: function () {
                        modifyToggler();
                    },
                    viewDidMount: function () {
                        modifyToggler();
                    }
                });

                // Render calendar
                calendar.render();
                // Modify sidebar toggler
                modifyToggler();
            })();
        });

        let events = [
            @foreach($calendars as $data)
            {
                id: {{ $data->id }},
                url: '{{ $data->url }}',
                @auth
                  @if (auth()->user()->role != "Freelance")
                    title: 'Tidak Tersedia',
                  @else
                    title: '{{ $data->title }}',
                  @endif
                @else
                  title: 'Tidak Tersedia',
                @endauth
                start: '{{ $data->start }}',
                end: '{{ $data->end }}',
                allDay: {{ $data->allDay ? 'true' : 'false' }},
                extendedProps: {
                    calendar: 'Booked'
                }
            },
            @endforeach
        ];
    </script>
  </body>
</html>
