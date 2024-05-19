import React, { useEffect, useRef, useState } from 'react'
import { Button, Label, Radio, Select as SelectFlowbite, Spinner, TextInput } from 'flowbite-react';
import Select from 'react-select';
import axios from 'axios';
import Requirement from '../alerts/Requirement';
import CitiesInput from './CitiesInput';

async function fetchCategoriesAnimals(){
    let response;
    await axios.get(`/ajax/animals/categories`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => response = res.data);
    return response;
}

function Professional({setOpenModal}) {
    const [services, setServices] = useState([]);
    const [service, setService] = useState();
    const [city, setCity] = useState({});
    const [housing, setHousing] = useState("");
    const [address, setAddress] = useState("");
    const [price, setPrice] = useState(0);
    const [selectedCategoriesAnimals, setSelectedCategoriesAnimals] = useState([]);
    const [options, setOptions] = useState([]);
    const [requirements, setRequirements] = useState([]);
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        axios.get(`/ajax/servicestype`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(response => {
            setServices(response.data);
        }).catch(error => console.error(error));

        fetchCategoriesAnimals().then(res => {
            let selectables = [];
            res.forEach(categories => {
                const select = {
                    "value": categories.id,
                    "label": categories.name
                };
                selectables.push(select);
            });
            setOptions(selectables);
        })
    }, []);

    const handleNumberInput = (e) => {
        const int = parseInt(e.key);
        if (!Number.isInteger(int) && e.key != "Backspace") {
            e.preventDefault();
        }
    }

    const onSubmit = async () => {
        if (handleForm() == true) {
            setLoading(true);
            await axios.post('/ajax/professional', {
                "service": service,
                "city": city,
                "housing": housing,
                "address": address,
                "price": price,
                "categories": selectedCategoriesAnimals
            }, 
            {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                }  
            }).then((e) => {
                window.location.reload();
            }).catch((err) => {
                setLoading(false);
                throw err;
            });
        }
    }

    const handleForm = () => {
        let arrayRequirements = [];

        if (city == null || city == "" || Object.keys(city).length == 0) {
            arrayRequirements.push("Veuillez choisir une ville.");
        }
        if (housing == null || housing == "") {
            arrayRequirements.push("Veuillez choisir une habitation.");
        }
        if (address == null || address == "") {
            arrayRequirements.push("L'adresse est vide, veuillez remplir l'adresse.");
        }
        if (price == "" || price == null) {
            arrayRequirements.push("Le prix est vide, veuillez insérer un prix.");
        }
        if (selectedCategoriesAnimals == null || selectedCategoriesAnimals.length == 0) {
            arrayRequirements.push("Veuillez choisir une catégorie d'animal.");
        }

        if (arrayRequirements.length > 0) {
            setRequirements(arrayRequirements);
            return false;
        }
        else {
            setRequirements([]);
            return true;
        }
    }

  return (
    <div className="space-y-6 mt-2">
        {requirements.length > 0 ? (<Requirement requirements={requirements} />) : null}
        <div className="flex justify-evenly">
            {service == null ? services.map(e => {
                return(
                    <div key={e.id}>
                        <Radio onClick={(el) => setService(el.target.value)} id={e.type} name="countries" value={e.id} className='hidden' />
                        <Label className='capitalize cursor-pointer p-2 rounded text-lg transition-all hover:bg-gray-200' htmlFor={e.type}>{e.type}</Label>
                    </div>
                )
            }) : null}
        </div>
        {service != null ? (
            <>
                <div className="mb-2 block">
                    <Label value='Selectionner votre ville:'></Label>
                </div>
                <CitiesInput onCitySelect={setCity} marginTop={"!mt-0"} />

                <div className="mb-2 block">
                    <Label htmlFor="housing" value="Entrer votre adresse:" />
                </div>
                <TextInput onChange={e => setAddress(e.target.value)} id="address" placeholder='10 rue de Strasbourg' required className='!mt-0'/>

                <div className="mb-2 block">
                    <Label htmlFor="housing" value="Selectionner votre habitation:" />
                </div>
                <SelectFlowbite id="housing" onChange={e => setHousing(e.target.value)} className='!mt-0' required>
                    <option value="">---------------</option>
                    <option value="appartment">Appartement</option>
                    <option value="house">Maison</option>
                </SelectFlowbite>

                <div className="mb-2 block">
                    <Label htmlFor="housing" value="Entrer votre prix (en €) par jour:" />
                </div>
                <TextInput maxLength={3} onKeyDown={e => handleNumberInput(e)} onChange={e => setPrice(e.target.value)} id="address" placeholder='32€' required className='!mt-0'/>

                <Select closeMenuOnSelect={false} menuPosition="fixed" value={selectedCategoriesAnimals} onChange={setSelectedCategoriesAnimals} isMulti options={options} className='basic-multi-select w-full' classNamePrefix="select" id="select-categories-animals" placeholder="Catégories d'animaux autorisées" />

                {loading ? (
                <Spinner className="m-auto h-10 w-10 text-blue-purple"/>
                ) : (
                <Button className="m-auto bg-blue-purple w-64 hover:opacity-75 hover:!bg-blue-purple" onClick={() => onSubmit()}>Créer un profil professionnel</Button>
                )}
            </>
        ) : null}
    </div>
  )
}

export default Professional