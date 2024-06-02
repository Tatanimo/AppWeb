import React, { useState } from 'react'
import SearchPetsitter from '../forms/SearchPetsitter'
import PetsitterCard from '../cards/PetsitterCard';
import Alerts from '../alerts/Alerts';

function Petsitting({id}) {
    const [petsitters, setPetsitters] = useState([]);
    console.log(petsitters.length)
  return (
    <>
        <div className="bg-beige w-full p-12 rounded-3xl max-w-[1152px] min-w-[1152px]">
            <SearchPetsitter id={id} onPetsittersFound={setPetsitters} />
        </div>
        <div className={`${petsitters.length > 1 && petsitters != "not found" ? "grid xl:grid-cols-3 grid-cols-2 justify-items-center grid-rows-1 gap-5" : ""} mt-8`}>
            {petsitters == "not found" ? (
                <Alerts fix={true} type={"info"} flash={[{title: "Aucun petsitter trouvé", message: "Veuillez réessayer une recherche sur un rayon plus grand."}, {}]} />
            ) : petsitters.map((e) => {
                const professional = e[0];
                const dist = e[1];
                return(
                    <PetsitterCard key={professional.id} professional={professional} dist={dist} />
                )
            })}
        </div>
    </>
  )
}

export default Petsitting