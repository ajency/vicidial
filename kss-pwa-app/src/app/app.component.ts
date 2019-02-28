// import { Component, OnInit } from '@angular/core';
// import { NgModule, Component, OnInit, VERSION, SystemJsNgModuleLoader, Injector, ViewContainerRef } from '@angular/core';
import {
    Component, Injector, NgModuleFactory, OnInit, SystemJsNgModuleLoader, ViewChild,
    ViewContainerRef
} from '@angular/core';
import { ApiService } from './services/api.service';
import { ConnectionService } from 'ng-connection-service';
import { PlatformLocation } from '@angular/common';


@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {

  // @ViewChild('container', {read: ViewContainerRef}) container: ViewContainerRef;

  title = 'kss-pwa-app';
  time : any;
  isConnected : any;
  status : any;
  msg : any;
  toastTimeout : any;
  showToast : boolean = false;  
  display : boolean = false;
  loadCart : boolean = false;
  constructor(private apiService: ApiService,
              private connectionService: ConnectionService,
              private loc : PlatformLocation,          
              private loader: SystemJsNgModuleLoader, private inj: Injector) { 

    this.connectionService.monitor().subscribe(isConnected => {
      console.log("event occured", isConnected);
      this.isConnected = isConnected;
      if (this.isConnected) {        
        this.status = "ONLINE";
        this.msg = "You are online!";
        this.displayToast();
        console.log("online");
        document.getElementsByTagName('body')[0].classList.remove('app-offline');                
      }
      else {        
        this.status = "OFFLINE";
        this.msg = "You are offline and may be viewing outdated info!";       
        this.displayToast();
        console.log("offline");
        document.getElementsByTagName('body')[0].classList.add('app-offline');
      }
    })

    if(!navigator.onLine){
        this.status = "OFFLINE";
        this.msg = "You are offline and may be viewing outdated info!";       
        this.displayToast();
        console.log("offline");
        document.getElementsByTagName('body')[0].classList.add('app-offline');
    }

// 
    // this.loc.onHashChange(()=>{
    //   console.log("hash changed", this.loc.hash);
    //   if(this.loc.hash == '#/bag'){
    //       this.loader.load('./bag/bag.module#BagModule')
    //         .then(factory => {
    //           const module = factory.create(this.injector);
    //           var entryComponentType = module.injector.get('LAZY_ENTRY_COMPONENT')
    //           var componentFactory = module.componentFactoryResolver.resolveComponentFactory(entryComponentType);
    //           this.vcr.createComponent(componentFactory);
    //         })
    //     }
    // })

  }

  displayToast(){
    clearTimeout(this.toastTimeout);  
    this.display = true;  
    this.showToast = true;
    this.toastTimeout = setTimeout(()=>{
      this.showToast = false;
    },4000)
  }

  ngOnInit(){
    // this.loader.load('./bag/bag.module#BagModule').then((moduleFactory: NgModuleFactory<any>) => {
    //         const entryComponent = (<any>moduleFactory.moduleType).entry;
    //         const moduleRef = moduleFactory.create(this.inj);

    //         const compFactory = moduleRef.componentFactoryResolver.resolveComponentFactory(entryComponent);
    //         this.container.createComponent(compFactory);
    //     });
  }

  goToHomePage(){
		if(!navigator.onLine){
			console.log("You are offline");
			alert("You are offline");
		}
		else{
			window.location.href = "/shop";
		}
	}
}

