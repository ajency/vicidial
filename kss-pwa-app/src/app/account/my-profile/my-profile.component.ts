import { Component, OnInit, ViewChild, Output, EventEmitter } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';
import { AccountService } from '../services/account.service';
import { EditUserPopupComponent } from '../../shared-components/edit-user/edit-user-popup/edit-user-popup.component';
import { Router, ActivatedRoute} from '@angular/router';

declare var $: any;

@Component({
  selector: 'app-my-profile',
  templateUrl: './my-profile.component.html',
  styleUrls: ['./my-profile.component.css']
})
export class MyProfileComponent implements OnInit {

  @Output() closeMyProfile = new EventEmitter();

  constructor(private appservice : AppServiceService,
              private apiservice : ApiServiceService,
              private account_service : AccountService,
              private router : Router) { }
  @ViewChild(EditUserPopupComponent)
  private editUserPopUp : EditUserPopupComponent;

  userInfo : any = {};
  showCancelButton : boolean = true;
  ngOnInit() {    
    this.appservice.removeLoader(); 
    this.getUserInfo();    
  }

  getUserInfo(){
    if(this.appservice.userInfo)
      this.userInfo = this.appservice.userInfo;
    else{
      this.appservice.showLoader();
      this.appservice.getUserInfo().then((response) =>{
        this.userInfo = response.user_info;
        this.appservice.userInfo = response.user_info;
        this.appservice.removeLoader();
      })
      .catch((error)=>{
        console.log("error in get-user-info api ==>",error);
        if(error.status == 401)
          this.account_service.userLogout();
        else if(error.status == 403)
          this.router.navigate(['account']);
        this.appservice.removeLoader();
      })
    }
  }

  closeWidget(){
    let url = window.location.href.split("#")[0];
    history.replaceState({}, 'account', url);
    this.appservice.closeCart();
  }

  navigateBack(){
     // history.back();
     this.closeMyProfile.emit();
  }

  showModal(){
    $('#user-info').modal('show');
    $('#user-info').on('shown.bs.modal', function () {
      $('[data-toggle="tooltip"]').tooltip();
    })
    $("#cd-cart,.kss_shipping_summary").css("overflow", "hidden");
    $('.modal-backdrop').appendTo('#cd-cart');
    $('body').addClass('hide-scroll');
  }

  updateEmail(){
    // console.log("this.editUserPopUp.userEmail", this.editUserPopUp.userEmail);
    this.userInfo.email = this.editUserPopUp.userEmail;
    this.userInfo.name = this.editUserPopUp.user_info.name;
    this.appservice.userInfo = this.userInfo;
  }

}
