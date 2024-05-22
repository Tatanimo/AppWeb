import React, {useEffect, useState} from 'react'
import Alerts from './Alerts';
import { EventSourcePolyfill } from 'event-source-polyfill';

export default function Mercure({jwtToken, urlMercure}) {
    const [alerts, setAlerts] = useState([]);
    
    useEffect(() => {
        const url = JSON.parse(urlMercure);
        const jwt = JSON.parse(jwtToken.replace(/\s/g, ''));

        const eventSource = new EventSourcePolyfill(url, { 
            withCredentials: true, 
            headers: {
                'Authorization': `Bearer ${jwt}`
            },
            heartbeatTimeout: 120000,
        });
        
        eventSource.onmessage = event => {
            setAlerts(prevAlerts => [...prevAlerts, JSON.parse(event.data)]);
        }
    }, [])
    
    if (alerts.length > 0) {
        return (
          <>
              {alerts.map((e, index) => {
                return(
                    <Alerts key={index} type={e.type} flash={e.flash}/>
                )
              })}
          </>
        )
    }
}
