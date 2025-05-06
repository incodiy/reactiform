import React, { useState } from 'react';
import { MapContainer, TileLayer, Marker, useMapEvents } from 'react-leaflet';
//import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import { ErrorDisplay } from './ErrorDisplay';

const LocationMarker = ({ onPositionChange }) => {
    useMapEvents({
        click(e) {
            onPositionChange([e.latlng.lat, e.latlng.lng]);
        }
    });
    return null;
};

/**
    $request->validate([
        'location_lat' => 'required|numeric|between:-90,90',
        'location_lng' => 'required|numeric|between:-180,180'
    ]);
 */
const GeolocationPicker = ({ config }) => {
    const [position, setPosition] = useState(config.default_coords);
    const [address, setAddress] = useState('');

    const handleSearch = async () => {
        const response = await fetch(
            `https://nominatim.openstreetmap.org/search?q=${address}&format=json`
        );
        const data = await response.json();
        if(data.length > 0) {
            setPosition([parseFloat(data[0].lat), parseFloat(data[0].lon)]);
        }
    };

    const [errors, setErrors] = useState([]);

    useEffect(() => {
        if(config.attributes['data-errors']) {
            setErrors(JSON.parse(config.attributes['data-errors']));
        }
    }, [config.attributes]);

    return (
        <div className="geolocation-picker">
            <div className="map-search">
                <input
                    type="text"
                    value={address}
                    onChange={(e) => setAddress(e.target.value)}
                    placeholder="Enter address"
                />
                <button type="button" onClick={handleSearch}>
                    Search
                </button>
            </div>
            
            <input type="hidden" name={`${config.name}_lat`} value={position[0]} />
            <input type="hidden" name={`${config.name}_lng`} value={position[1]} />
            
            <div className="map-container" style={{ height: config.map_height }}>
                <MapContainer center={position} zoom={13}>
                    <TileLayer
                        url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                        attribution='&copy; OpenStreetMap contributors'
                    />
                    <Marker position={position}>
                        <Popup>Selected Location</Popup>
                    </Marker>
                    <LocationMarker onPositionChange={setPosition} />
                </MapContainer>
            </div>

            <ErrorDisplay errors={errors} />
        </div>
    );
};

export default GeolocationPicker;
// This component uses the react-leaflet library to create a map for geolocation selection.