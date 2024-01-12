<div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
              <div class=" dropdown-header noti-title">
                <h6 class="text-overflow m-0">Bienvenidos!</h6>
              </div>
              <a href="/profile" class="dropdown-item">
                <i class="ni ni-single-02"></i>
                <span>Mi perfil</span>
              </a>
             
              <a href="/miscitas" class="dropdown-item">
                <i class="far fa-clock"></i>
                <span>Citas</span>
              </a>
              <a href="/reservarcitas/create" class="dropdown-item">
                <i class="ni ni-support-16"></i>
                <span>Reservar Cita</span>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('formLogout').submit();">
                <i class="ni ni-user-run"></i>
                <span>Cerrar Sesión</span>
                <form action="{{route('logout')}}" method="POST" style="display: none;" id="formLogout">
                @csrf
                </form>
              </a>
            </div>