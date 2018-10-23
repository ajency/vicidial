import { Injectable } from '@angular/core';
import { Headers, Http } from '@angular/http';

import 'rxjs/add/operator/toPromise';

@Injectable()
export class ApiServiceService {

	handleError : any;
  constructor( private http : Http) { 
  	        this.handleError = (error: any): Promise<any> => {
			        console.warn('error in request fetch',error)
			        console.log(error.status);
			        let prerror = this.parseRejectedError(error);
			        return Promise.reject(prerror);
		        }
  }

	public request(url: string,type: string, body: object, optionalHeaders: object = {},overrideheaders: boolean = false, returntype: string = 'promise',): any{
	  let headers = new Headers({'Content-Type': 'application/json'});
	  let opHeaderKeys = Object.keys(optionalHeaders);
	  if(opHeaderKeys.length){
	    if(overrideheaders){
	      headers = new Headers(optionalHeaders);
	    }
	    else{
	      for(let key of opHeaderKeys){
	        headers.append(key,optionalHeaders[key]);
	      }
	    }
	  }
	  
	  let httpEvent;
		if(type == 'get'){
		  httpEvent = this.http.get(url,{headers: headers});
		}
		else if(type == 'post'){
		  httpEvent = this.http.post(url,body,{headers: headers})
		}
		else if(type == 'put'){
		  httpEvent = this.http.put(url,body,{headers: headers})
		}

		if(returntype == 'promise'){
		  return httpEvent
		  .toPromise()
		  .then((response) => {
		   return response.json()
		 })
		  .catch(this.handleError);
		}
		else{
		  return httpEvent
		  .map((response) => {
		   return response.json()
		 })
		  .catch(this.handleError);
		}
	}

	public parseRejectedError(error: any): any{
    try{
      return JSON.parse(error._body);
    }
    catch(e){
      return error;
    }
  }


}