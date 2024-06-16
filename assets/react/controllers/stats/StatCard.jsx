import React, {useEffect, useState} from "react";
import axios from "axios";
import { ReactSVG } from "react-svg";

export default function StatCard({controller, endpoint, title, icon}) {
  const [data, setData] = useState(0);
  const [loading, isLoading] = useState(true);

  useEffect(() => {
    let url = "";
    switch (controller) {
      case "google_analytics":
        url = "/admin/ajax/google/analytics/";
        break;
      case "users":
        url = "/ajax/";
        break;
      case "stats":
        url = "/admin/ajax/stats/";
        break;
    }
    axios.get(`${url}${endpoint}`, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
    }})
    .then(response => {
        setData(response.data);
    })
    .catch(error => console.error(error))
    .finally(() => isLoading(false));
  }, []);

  return (
    <div className="border-2 border-gray-200 px-4 py-6 rounded-lg">
        <ReactSVG id="stat-icon" className="stroke-indigo-500 text-indigo-500 max-w-12 max-h-12 min-w-12 min-h-12 mb-3 inline-block" src={`/img/icons/admin/${icon}.svg`} />
        {loading ? (
          <div className="flex space-x-2 animate-pulse justify-center my-2">
            <div className="w-3 h-3 bg-gray-400 rounded-full"></div>
            <div className="w-3 h-3 bg-gray-400 rounded-full"></div>
            <div className="w-3 h-3 bg-gray-400 rounded-full"></div>
          </div>
        ) : (
          <h2 className="title-font font-medium text-3xl text-gray-900">{data} {endpoint == "total-rating" ? "/ 5" : null}</h2>
        )}
        <p className="leading-relaxed">{title}</p>
    </div>
  )
}
