<aside class="aside-md bg-light dk hidden-xs" id="sidebar">
    <section class="vbox animated fadeInRight">
        <section class="w-f-md scrollable hover">
            <h4 class="font-thin m-l-md m-t">Friends</h4>
            <ul class="list-group no-bg no-borders auto m-t-n-xxs">
                <li class="list-group-item">
                      <span class="pull-left thumb-xs m-t-xs avatar m-l-xs m-r-sm">
                        <img src="https://www.gravatar.com/avatar/{{md5(strtolower(trim('friend-user-email')))}}?d=retro" alt="..." class="img-circle">
                        <i class="on b-light right sm"></i>
                      </span>
                      <div class="clear">
                          <div><a href="#">{{Faker\Provider\en_US\Person::firstNameMale()}}</a></div>
                          <small class="text-muted">{{Faker\Provider\en_US\Address::state()}}</small>
                      </div>
                </li>
                <li class="list-group-item">
                    <span class="pull-left thumb-xs m-t-xs avatar m-l-xs m-r-sm">
                      <img src="https://www.gravatar.com/avatar/{{md5(strtolower(trim('friend@user.email')))}}?d=retro">
                      <i class="off b-light right sm"></i>
                    </span>
                    <div class="clear">
                      <div><a href="#">{{Faker\Provider\en_US\Person::firstNameFemale()}} {{Faker\Provider\en_US\Person::firstNameFemale()}}</a></div>
                      <small class="text-muted">{{Faker\Provider\en_US\Address::state()}}</small>
                    </div>
                </li>
            </ul>
        </section>
        <footer class="footer footer-md bg-black">
           {{-- <form class="" role="search">
                <div class="form-group clearfix m-b-none">
                    <div class="input-group m-t m-b">
                                <span class="input-group-btn">
                                  <button type="submit" class="btn btn-sm bg-empty text-muted btn-icon"><i class="fa fa-search"></i></button>
                                </span>
                        <input type="text" class="form-control input-sm text-white bg-empty b-b b-dark no-border" placeholder="Search members">
                    </div>
                </div>
            </form>--}}
        </footer>
    </section>
</aside>
