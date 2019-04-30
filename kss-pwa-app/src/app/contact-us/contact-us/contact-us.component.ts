import { Component, OnInit, isDevMode } from '@angular/core';
import { ApiServiceService } from '../../service/api-service.service';
import { AppServiceService } from '../../service/app-service.service';

@Component({
  selector: 'app-contact-us',
  templateUrl: './contact-us.component.html',
  styleUrls: ['./contact-us.component.scss']
})
export class ContactUsComponent implements OnInit {

  breadcrumbs : any = [
    {position: 1, title: 'Home', url: '/'},
    {position: 2, title: 'Contact Us', url: '/contact'},
  ];
  submitLoader : boolean = false;
  contactApiSuccess : boolean = false;
  contactApiFailure : boolean = false;
  constructor(private apiService: ApiServiceService,
              private appservice : AppServiceService) { }

  ngOnInit() {
  }

  register(form){
    console.log("form values ==>", form);
    if(form.valid){
      this.submitLoader = true;
      let url = isDevMode() ? "https://demo8558685.mockable.io/send-contach-details" : "/api/rest/v1/send-contact-details";

      this.apiService.request(url,'post', form.value, {}).then((data)=>{
        this.submitLoader = false;
        form.reset();
        form.submitted = false;
        this.contactApiSuccess = true;
      })
      .catch((error)=>{
        console.log("error in get-home-page-element api ==>", error);
        this.submitLoader = false;
        this.contactApiFailure = true;
      })
    }
  }

}
