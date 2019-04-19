import { Injectable } from '@angular/core';
import { Observable, Subject, asapScheduler, pipe, of, from, interval, merge, fromEvent } from 'rxjs';
import { map, filter, scan } from 'rxjs/operators';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class ApiServiceService {

  handleError : any;
  constructor(private http : HttpClient) {
  	this.handleError = (error: any): Promise<any> => {
			        let prerror = this.parseRejectedError(error);
			        return Promise.reject(prerror);
		        }
   }

  	public request(url: string,type: string, body: object, optionalHeaders: object = {},overrideheaders: boolean = false, returntype: string = 'promise'): any{
	  let headers = new HttpHeaders({'Content-Type': 'application/json'});
	  let opHeaderKeys = Object.keys(optionalHeaders);
	  // if(opHeaderKeys.length){
	  //   if(overrideheaders){
	  //     headers = new Headers(optionalHeaders);
	  //   }
	  //   else{
	  //     for(let key of opHeaderKeys){
	  //       headers.append(key,optionalHeaders[key]);
	  //     }
	  //   }
	  // }
	  if(opHeaderKeys.length){
		  	// console.log("optionalHeaders are present", optionalHeaders);			    
		    headers = new HttpHeaders({'Content-Type': 'application/json', 'Authorization' : optionalHeaders['Authorization']});
		   	// console.log("headers ==>", headers);
		}
	  
	  let httpEvent;
		if(type == 'get'){
		  httpEvent = this.http.get(url,{params : this.toHttpParams(body), headers: headers});
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
		   return response;
		 })
		  .catch(this.handleError);
		}
		else{
		  return httpEvent
		 //  .map((response) => {
		 //   return response.json()
		 // })
		 //  .catch(this.handleError);
		}
	}

	public parseRejectedError(error: any): any{
	    try{
	    	let error_object = {
	    		message : JSON.parse(error._body).message,
	    		status : error.status
	    	}
	      return error_object
	    }
	    catch(e){
	      return error;
	    }
	}

	toHttpParams(params) {
    return Object.getOwnPropertyNames(params)
                 .reduce((p, key) => p.set(key, params[key]), new HttpParams());
	}


}
