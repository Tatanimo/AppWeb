import { Button, Datepicker, Modal, Select, Spinner, TextInput, Textarea } from 'flowbite-react';
import React, { useEffect, useState } from 'react'
import axios from 'axios';
import Requirement from '../alerts/Requirement';

async function fetchCategoriesAnimals() {
    let response;
    await axios.get('/ajax/categoriesanimals', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    }).then(res => response = res.data);
    return response;
}

async function fetchAnimal(id) {
    let response;
    await axios.get(`/ajax/animal/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    }).then(res => response = res.data);
    return response;
}

function AddUpdateAnimalModal({openModal, setOpenModal, animalId, setFetchById}) {
    const [loading, setLoading] = useState(false);
    const [categoriesAnimals, setCategoriesAnimals] = useState([]);
    const [value, setValue] = useState({});
    const [requirements, setRequirements] = useState([]);

    useEffect(() => {
        fetchCategoriesAnimals().then(res => setCategoriesAnimals(res));
        if (animalId) {
            fetchAnimal(animalId).then(res => {
                res.birthdate = new Date(res.birthdate).toLocaleDateString();
                res.category = res.fk_categoryId;
                res.animalId = res.id;
                setValue(res);
            });
        }
    }, []);
    
    const handleSubmit = () => {
        const validBirthdate = new RegExp(/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/);
        let arrayRequirements = [];
        if (!validBirthdate.test(value.birthdate)) {
            arrayRequirements.push("La date de naissance n'est pas au format valide: jj-mm-yyyy");
        }
        if (value.category == NaN || value.category == undefined) {
            arrayRequirements.push("La catégorie choisi n'est pas valide");
        }
        if (value.weight == NaN) {
            arrayRequirements.push("Le poid n'est pas au bon format: 75.2");
        }
        if (value.name == "" || value.name == undefined) {
            arrayRequirements.push("Le nom de l'animal est requis");
        }
        if (arrayRequirements.length > 0) {
            setRequirements(arrayRequirements);
        }
        else {
            setRequirements([]);
            saveAnimal();
        }
    }

    const saveAnimal = async () => {
        setLoading(true);
        await axios.post(`/ajax/animal`, value, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            setFetchById(response.data);
            setLoading(false);
        })
        .catch(error => {
            console.error(error)
            setLoading(false)});
    }

  return (
    <Modal className="" dismissible show={openModal} size="md" popup onClose={() => setOpenModal(false)}>
        <Modal.Header>
         {animalId ? "Modifier" : "Ajouter"} un animal
        </Modal.Header>
        <Modal.Body>
            <div className="space-y-6 ">
                {requirements.length > 0 ? (<Requirement requirements={requirements} />) : null}
                <div>
                    <TextInput className="[&>div>input]:bg-light-gray" id="name" placeholder="Nom de l'animal*" onChange={e => setValue({...value, name: e.target.value})} value={value.name ?? ""} autoFocus required />
                </div>
                <div>
                    <Select className='w-full [&>div>select]:bg-light-gray [&>div>select]:text-gray-500' value={value.category ?? ""} onChange={e => setValue({...value, category: parseInt(e.target.value)})}>
                        <option>Selectionner la catégorie de l'animal*</option>
                        {categoriesAnimals.map((e) => {
                            return(
                                <option key={e.id} value={e.id}>{e.name}</option>
                            )
                        })}
                    </Select>
                </div>
                <div className="flex">
                    <TextInput className="[&>div>input]:bg-light-gray mr-3" id="race" placeholder="Race" onChange={e => setValue({...value, race: e.target.value})} value={value.race ?? ""} />
                    <TextInput type='number' className="[&>div>input]:bg-light-gray ml-3" id="weight" placeholder="Poids en KG" value={value.weight ?? ""} onChange={e => {
                    e.target.value != "" ? 
                    setValue({...value, weight: parseFloat(e.target.value)}): setValue({...value, weight: null})}} />
                </div>
                <div>
                    <Datepicker language='FR' placeholder='Date de naissance*' maxDate={new Date()} className="[&>div>div>input]:bg-light-gray" required value={value.birthdate ?? ""} onSelectedDateChanged={e => setValue({...value, birthdate: new Date(e).toLocaleDateString()})} />
                </div>
                <div>
                    <Textarea className="bg-light-gray" id="password" placeholder="Insérer une description de l'animal" value={value.description ?? ""} onChange={e => setValue({...value, description: e.target.value})} />
                </div>
                <div className="w-full flex justify-center">
                    {loading ? (
                    <Spinner className="m-auto h-10 w-10 text-blue-purple"/>
                    ) : (
                    <Button className="m-auto bg-blue-purple w-64 hover:opacity-75 hover:!bg-blue-purple" onClick={() => handleSubmit()}>{animalId ? "Modifier" : "Ajouter"} l'animal</Button>
                    )}
                </div>
            </div>
        </Modal.Body>
    </Modal>
  )
}

export default AddUpdateAnimalModal