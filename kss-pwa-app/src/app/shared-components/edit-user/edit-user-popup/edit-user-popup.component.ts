import { Component, OnInit, Input, Output, OnChanges, EventEmitter } from '@angular/core';
import { AppServiceService } from '../../../service/app-service.service';
import { ApiServiceService } from '../../../service/api-service.service';


declare var $: any;

@Component({
  selector: 'app-edit-user-popup',
  templateUrl: './edit-user-popup.component.html',
  styleUrls: ['./edit-user-popup.component.css']
})
export class EditUserPopupComponent implements OnInit, OnChanges {

	@Input() user_info : any;
	@Input() showCancelButton : any;
  @Input() showMobileNumber : any;
	@Output() pop_up_closed = new EventEmitter();
  @Output() showPayButton = new EventEmitter();
	userEmail : any;
  userName : any;
  constructor(private appservice : AppServiceService,
              private apiservice : ApiServiceService) { }

  ngOnInit() {
  }

  ngOnChanges(){
  	// console.log("ngOnChanges edit-user-popup", this.user_info, this.showCancelButton, this.showMobileNumber);
  	this.userEmail = this.user_info.email;
    this.userName = this.user_info.name;
  }

  saveUserInfo(){
    this.appservice.showLoader();
    let url = this.appservice.apiUrl + '/api/rest/v1/user/save-user-details';
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    let body : any = {
      _token : $('meta[name="csrf-token"]').attr('content'),
      name : this.userName,
      email : this.userEmail
    };

    this.apiservice.request(url, 'post', body , header ).then((response)=>{
      this.userEmail = body.email;
      this.user_info.email = body.email;
      this.user_info.name = body.name;
      this.pop_up_closed.emit(true);
      this.hideModal();
      this.appservice.removeLoader();
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.appservice.removeLoader();
    }) 
  }

  hideModal(){
    this.showPayButton.emit(true);
    this.userEmail = this.user_info.email;
    this.userName = this.user_info.name;
    $('#user-info').modal('hide');
    $("#cd-cart,.kss_shipping_summary").css("overflow", "auto");
    $('.modal-backdrop').remove();
  }

}
