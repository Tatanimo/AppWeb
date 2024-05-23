import { Button, Modal, Spinner } from 'flowbite-react';
import React, { useEffect, useState } from 'react'
import axios from 'axios';
import Requirement from '../alerts/Requirement';
import Select from 'react-select';

async function fetchCategoriesAnimalsNotInProfessional(id){
    let response;
    await axios.get(`/ajax/categoriesanimals/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => response = res.data);
    return response;
}

function AddCategoryAnimalModal({openModal, setOpenModal, professionalId, setCategoriesAnimals}) {
    const [loading, setLoading] = useState(false);
    const [requirements, setRequirements] = useState([]);
    const [options, setOptions] = useState([]);
    const [selectedCategoriesAnimals, setSelectedCategoriesAnimals] = useState([]);

    useEffect(() => {
        fetchCategoriesAnimalsNotInProfessional(professionalId).then(res => {
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

    const handleSubmit = async () => {
        if (handleForm() == true) {
            setLoading(true);
            axios.post(`/ajax/categoriesanimals/add/${professionalId}`, {
                categories: selectedCategoriesAnimals
            }, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => {
                setOpenModal(false);
                setCategoriesAnimals(res.data.allowed_categories);
            })
            .catch(err => console.error(err))
            .finally(() => setLoading(false));
        }   
    }

    const handleForm = () => {
        let arrayRequirements = [];

        if (selectedCategoriesAnimals.length == 0 || selectedCategoriesAnimals == null) {
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
    <Modal className="" dismissible show={openModal} size="md" popup onClose={() => setOpenModal(false)}>
        <Modal.Header>
         Ajouter des catégories d'animaux autorisées
        </Modal.Header>
        <Modal.Body>
            <div className="space-y-6 ">
                <br />
                {requirements.length > 0 ? (<Requirement requirements={requirements} />) : null}
                <Select menuPosition="fixed" closeMenuOnSelect={false} value={selectedCategoriesAnimals} onChange={setSelectedCategoriesAnimals} isMulti options={options} className='basic-multi-select w-full' classNamePrefix="select" id="select-categories-animals" placeholder="Catégories d'animaux autorisées" />
                <br />
                <div className="w-full flex justify-center">
                    {loading ? (
                    <Spinner className="m-auto h-10 w-10 text-blue-purple"/>
                    ) : (
                    <Button className="m-auto bg-blue-purple w-64 hover:opacity-75 hover:!bg-blue-purple" onClick={() => handleSubmit()}>Ajouter les catégories</Button>
                    )}
                </div>
            </div>
        </Modal.Body>
    </Modal>
  )
}

export default AddCategoryAnimalModal