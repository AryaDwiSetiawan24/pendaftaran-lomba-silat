<script type="module">
import React, { useState } from 'react';
import { Menu, X, Calendar, Trophy, Users, LogIn, LogOut, Plus, Edit, Trash2, Eye, Bell, Search, Filter } from
'lucide-react';

const SilatCompetitionUI = () => {
const [currentView, setCurrentView] = useState('landing');
const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
const [formData, setFormData] = useState({
name: '',
description: '',
registration_start_date: '',
registration_end_date: '',
status: 'akan_datang'
});
const [errors, setErrors] = useState({});
</script>
// Landing Page
const LandingPage = () => (
<div className="min-h-screen bg-gradient-to-br from-red-900 via-red-800 to-orange-900">
    {/* Navbar */}
    <nav className="bg-black bg-opacity-50 backdrop-blur-md fixed w-full z-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="flex justify-between items-center h-16">
                <div className="flex items-center">
                    <Trophy className="h-8 w-8 text-yellow-400" />
                    <span className="ml-2 text-xl font-bold text-white">Lomba Silat Indonesia</span>
                </div>

                <div className="hidden md:flex items-center space-x-8">
                    <a href="#lomba" className="text-white hover:text-yellow-400 transition">Lomba</a>
                    <a href="#jadwal" className="text-white hover:text-yellow-400 transition">Jadwal</a>
                    <a href="#klasemen" className="text-white hover:text-yellow-400 transition">Klasemen</a>
                    <a href="#tentang" className="text-white hover:text-yellow-400 transition">Tentang</a>
                </div>

                <div className="hidden md:flex items-center space-x-4">
                    <button onClick={()=> setCurrentView('user')}
                        className="px-4 py-2 text-white border border-white rounded-lg hover:bg-white hover:text-red-900 transition"
                        >
                        Login Peserta
                    </button>
                    <button onClick={()=> setCurrentView('admin')}
                        className="px-4 py-2 bg-yellow-400 text-red-900 rounded-lg font-semibold hover:bg-yellow-300 transition"
                        >
                        Login Admin
                    </button>
                </div>

                <button className="md:hidden text-white" onClick={()=> setIsMobileMenuOpen(!isMobileMenuOpen)}>
                    {isMobileMenuOpen ?
                    <X /> :
                    <Menu />}
                </button>
            </div>
        </div>

        {isMobileMenuOpen && (
        <div className="md:hidden bg-black bg-opacity-90 px-4 py-4 space-y-3">
            <a href="#lomba" className="block text-white hover:text-yellow-400">Lomba</a>
            <a href="#jadwal" className="block text-white hover:text-yellow-400">Jadwal</a>
            <a href="#klasemen" className="block text-white hover:text-yellow-400">Klasemen</a>
            <button onClick={()=> setCurrentView('user')}
                className="block w-full text-left text-white hover:text-yellow-400">Login Peserta</button>
            <button onClick={()=> setCurrentView('admin')}
                className="block w-full text-left text-white hover:text-yellow-400">Login Admin</button>
        </div>
        )}
    </nav>

    {/* Hero Section */}
    <div className="pt-32 pb-20 px-4">
        <div className="max-w-7xl mx-auto text-center">
            <h1 className="text-5xl md:text-7xl font-bold text-white mb-6 animate-fade-in">
                Unjuk Kebolehan<br />
                <span className="text-yellow-400">Seni Bela Diri Nusantara</span>
            </h1>
            <p className="text-xl text-gray-200 mb-8 max-w-2xl mx-auto">
                Platform terpadu untuk pendaftaran dan manajemen lomba silat se-Indonesia
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
                <button
                    className="px-8 py-4 bg-yellow-400 text-red-900 rounded-lg font-bold text-lg hover:bg-yellow-300 transition transform hover:scale-105">
                    Daftar Lomba Sekarang
                </button>
                <button
                    className="px-8 py-4 bg-white bg-opacity-20 text-white rounded-lg font-bold text-lg hover:bg-opacity-30 transition backdrop-blur">
                    Lihat Jadwal
                </button>
            </div>
        </div>
    </div>

    {/* Lomba Cards */}
    <div className="max-w-7xl mx-auto px-4 pb-20">
        <h2 className="text-3xl font-bold text-white mb-8 text-center">Lomba Yang Tersedia</h2>
        <div className="grid md:grid-cols-3 gap-6">
            {[
            { title: 'Kejuaraan Nasional Silat 2025', date: '15-17 Oktober 2025', peserta: 156, kategori: 'Tanding &
            Seni' },
            { title: 'Piala Gubernur Jawa Tengah', date: '5-7 November 2025', peserta: 89, kategori: 'Tanding' },
            { title: 'Festival Silat Nusantara', date: '1-3 Desember 2025', peserta: 234, kategori: 'Seni' }
            ].map((lomba, idx) => (
            <div key={idx}
                className="bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-6 hover:bg-opacity-20 transition transform hover:scale-105">
                <div className="bg-yellow-400 text-red-900 text-xs font-bold px-3 py-1 rounded-full inline-block mb-4">
                    {lomba.kategori}
                </div>
                <h3 className="text-xl font-bold text-white mb-3">{lomba.title}</h3>
                <div className="space-y-2 text-gray-200">
                    <p className="flex items-center">
                        <Calendar className="h-4 w-4 mr-2" /> {lomba.date}
                    </p>
                    <p className="flex items-center">
                        <Users className="h-4 w-4 mr-2" /> {lomba.peserta} Peserta
                    </p>
                </div>
                <button
                    className="mt-4 w-full py-2 bg-yellow-400 text-red-900 rounded-lg font-semibold hover:bg-yellow-300 transition">
                    Daftar Sekarang
                </button>
            </div>
            ))}
        </div>
    </div>
</div>
);

// Admin Dashboard
const AdminDashboard = () => (
<div className="min-h-screen bg-gray-100">
    {/* Admin Navbar */}
    <nav className="bg-red-900 text-white shadow-lg">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="flex justify-between items-center h-16">
                <div className="flex items-center">
                    <Trophy className="h-8 w-8 text-yellow-400" />
                    <span className="ml-2 text-xl font-bold">Admin Dashboard</span>
                </div>
                <div className="flex items-center space-x-4">
                    <Bell className="h-6 w-6 cursor-pointer hover:text-yellow-400" />
                    <div className="flex items-center space-x-2">
                        <div
                            className="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center text-red-900 font-bold">
                            A
                        </div>
                        <span>Admin</span>
                    </div>
                    <button onClick={()=> setCurrentView('landing')}
                        className="flex items-center hover:text-yellow-400">
                        <LogOut className="h-5 w-5 mr-1" /> Logout
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <div className="flex">
        {/* Sidebar */}
        <div className="w-64 bg-white h-screen shadow-lg">
            <div className="p-6 space-y-2">
                <button onClick={()=> setCurrentView('admin')}
                    className={`w-full flex items-center px-4 py-3 rounded-lg ${currentView === 'admin' ? 'bg-red-900
                    text-white' : 'text-gray-700 hover:bg-gray-100'}`}
                    >
                    <Trophy className="h-5 w-5 mr-3" /> Dashboard
                </button>
                <button onClick={()=> setCurrentView('admin-add-lomba')}
                    className={`w-full flex items-center px-4 py-3 rounded-lg ${currentView === 'admin-add-lomba' ?
                    'bg-red-900 text-white' : 'text-gray-700 hover:bg-gray-100'}`}
                    >
                    <Plus className="h-5 w-5 mr-3" /> Lomba Baru
                </button>
                <button className="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <Users className="h-5 w-5 mr-3" /> Peserta
                </button>
                <button className="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <Calendar className="h-5 w-5 mr-3" /> Jadwal
                </button>
            </div>
        </div>

        {/* Main Content */}
        <div className="flex-1 p-8">
            {/* Stats Cards */}
            <div className="grid md:grid-cols-4 gap-6 mb-8">
                {[
                { title: 'Total Lomba', value: '12', icon: Trophy, color: 'bg-blue-500' },
                { title: 'Total Peserta', value: '487', icon: Users, color: 'bg-green-500' },
                { title: 'Lomba Aktif', value: '3', icon: Calendar, color: 'bg-yellow-500' },
                { title: 'Jadwal Hari Ini', value: '8', icon: Calendar, color: 'bg-red-500' }
                ].map((stat, idx) => (
                <div key={idx} className="bg-white rounded-xl shadow p-6">
                    <div className="flex items-center justify-between">
                        <div>
                            <p className="text-gray-500 text-sm">{stat.title}</p>
                            <p className="text-3xl font-bold mt-2">{stat.value}</p>
                        </div>
                        <div className={`${stat.color} p-3 rounded-lg`}>
                            <stat.icon className="h-6 w-6 text-white" />
                        </div>
                    </div>
                </div>
                ))}
            </div>

            {/* Lomba Management */}
            <div className="bg-white rounded-xl shadow">
                <div className="p-6 border-b border-gray-200 flex justify-between items-center">
                    <h2 className="text-xl font-bold">Manajemen Lomba</h2>
                    <button onClick={()=> setCurrentView('admin-add-lomba')}
                        className="px-4 py-2 bg-red-900 text-white rounded-lg hover:bg-red-800 transition flex items-center"
                        >
                        <Plus className="h-4 w-4 mr-2" /> Tambah Lomba
                    </button>
                </div>
                <div className="p-6">
                    <div className="flex gap-4 mb-6">
                        <div className="flex-1 relative">
                            <Search
                                className="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" />
                            <input type="text" placeholder="Cari lomba..."
                                className="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent" />
                        </div>
                        <button
                            className="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center">
                            <Filter className="h-4 w-4 mr-2" /> Filter
                        </button>
                    </div>

                    <div className="overflow-x-auto">
                        <table className="w-full">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama
                                        Lomba</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Tanggal</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Peserta</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Status</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-200">
                                {[
                                { nama: 'Kejuaraan Nasional Silat 2025', tanggal: '15-17 Okt 2025', peserta: 156,
                                status: 'Aktif' },
                                { nama: 'Piala Gubernur Jawa Tengah', tanggal: '5-7 Nov 2025', peserta: 89, status:
                                'Pendaftaran' },
                                { nama: 'Festival Silat Nusantara', tanggal: '1-3 Des 2025', peserta: 234, status:
                                'Pendaftaran' }
                                ].map((lomba, idx) => (
                                <tr key={idx} className="hover:bg-gray-50">
                                    <td className="px-6 py-4 font-medium">{lomba.nama}</td>
                                    <td className="px-6 py-4 text-gray-600">{lomba.tanggal}</td>
                                    <td className="px-6 py-4 text-gray-600">{lomba.peserta}</td>
                                    <td className="px-6 py-4">
                                        <span className={`px-3 py-1 rounded-full text-xs font-semibold ${ lomba.status
                                            === 'Aktif' ? 'bg-green-100 text-green-800'
                                            : 'bg-blue-100 text-blue-800' }`}>
                                            {lomba.status}
                                        </span>
                                    </td>
                                    <td className="px-6 py-4">
                                        <div className="flex space-x-2">
                                            <button className="p-2 text-blue-600 hover:bg-blue-50 rounded">
                                                <Eye className="h-4 w-4" />
                                            </button>
                                            <button className="p-2 text-yellow-600 hover:bg-yellow-50 rounded">
                                                <Edit className="h-4 w-4" />
                                            </button>
                                            <button className="p-2 text-red-600 hover:bg-red-50 rounded">
                                                <Trash2 className="h-4 w-4" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
);

// Add Lomba Form
const AddLombaForm = () => {
const handleInputChange = (e) => {
const { name, value } = e.target;
setFormData(prev => ({
...prev,
[name]: value
}));
// Clear error when user types
if (errors[name]) {
setErrors(prev => ({
...prev,
[name]: ''
}));
}
};

const validateForm = () => {
const newErrors = {};

if (!formData.name.trim()) {
newErrors.name = 'Nama lomba wajib diisi';
}

if (!formData.registration_start_date) {
newErrors.registration_start_date = 'Tanggal mulai pendaftaran wajib diisi';
}

if (!formData.registration_end_date) {
newErrors.registration_end_date = 'Tanggal akhir pendaftaran wajib diisi';
}

if (formData.registration_start_date && formData.registration_end_date) {
if (new Date(formData.registration_end_date) <= new Date(formData.registration_start_date)) {
    newErrors.registration_end_date = 'Tanggal akhir harus setelah tanggal mulai'; } } setErrors(newErrors); return
    Object.keys(newErrors).length===0; }; const handleSubmit=(e)=> {
    e.preventDefault();

    if (validateForm()) {
    // Simulate successful submission
    alert('Lomba berhasil ditambahkan!\n\n' + JSON.stringify(formData, null, 2));
    // Reset form
    setFormData({
    name: '',
    description: '',
    registration_start_date: '',
    registration_end_date: '',
    status: 'akan_datang'
    });
    setCurrentView('admin');
    }
    };

    const handleCancel = () => {
    setFormData({
    name: '',
    description: '',
    registration_start_date: '',
    registration_end_date: '',
    status: 'akan_datang'
    });
    setErrors({});
    setCurrentView('admin');
    };

    return (
    <div className="min-h-screen bg-gray-100">
        {/* Admin Navbar */}
        <nav className="bg-red-900 text-white shadow-lg">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between items-center h-16">
                    <div className="flex items-center">
                        <Trophy className="h-8 w-8 text-yellow-400" />
                        <span className="ml-2 text-xl font-bold">Admin Dashboard</span>
                    </div>
                    <div className="flex items-center space-x-4">
                        <Bell className="h-6 w-6 cursor-pointer hover:text-yellow-400" />
                        <div className="flex items-center space-x-2">
                            <div
                                className="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center text-red-900 font-bold">
                                A
                            </div>
                            <span>Admin</span>
                        </div>
                        <button onClick={()=> setCurrentView('landing')}
                            className="flex items-center hover:text-yellow-400">
                            <LogOut className="h-5 w-5 mr-1" /> Logout
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <div className="flex">
            {/* Sidebar */}
            <div className="w-64 bg-white h-screen shadow-lg">
                <div className="p-6 space-y-2">
                    <button onClick={()=> setCurrentView('admin')}
                        className="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg"
                        >
                        <Trophy className="h-5 w-5 mr-3" /> Dashboard
                    </button>
                    <button onClick={()=> setCurrentView('admin-add-lomba')}
                        className="w-full flex items-center px-4 py-3 bg-red-900 text-white rounded-lg"
                        >
                        <Plus className="h-5 w-5 mr-3" /> Lomba Baru
                    </button>
                    <button className="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <Users className="h-5 w-5 mr-3" /> Peserta
                    </button>
                    <button className="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <Calendar className="h-5 w-5 mr-3" /> Jadwal
                    </button>
                </div>
            </div>

            {/* Main Content */}
            <div className="flex-1 p-8">
                {/* Breadcrumb */}
                <div className="mb-6">
                    <div className="flex items-center text-sm text-gray-600">
                        <button onClick={()=> setCurrentView('admin')}
                            className="hover:text-red-900">Dashboard</button>
                        <span className="mx-2">/</span>
                        <span className="text-red-900 font-semibold">Tambah Lomba Baru</span>
                    </div>
                </div>

                {/* Form Card */}
                <div className="bg-white rounded-xl shadow-lg">
                    <div className="p-6 border-b border-gray-200">
                        <h2 className="text-2xl font-bold text-gray-800">Tambah Lomba Baru</h2>
                        <p className="text-gray-600 mt-1">Isi informasi lengkap tentang lomba silat yang akan
                            diselenggarakan</p>
                    </div>

                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="space-y-6">
                            {/* Nama Lomba */}
                            <div>
                                <label htmlFor="name" className="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lomba <span className="text-red-600">*</span>
                                </label>
                                <input type="text" id="name" name="name" value={formData.name}
                                    onChange={handleInputChange} placeholder="Contoh: Kejuaraan Nasional Silat 2025"
                                    className={`w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-red-900
                                    focus:border-transparent transition ${ errors.name ? 'border-red-500'
                                    : 'border-gray-300' }`} />
                                {errors.name && (
                                <p className="mt-2 text-sm text-red-600 flex items-center">
                                    <span className="mr-1">⚠</span> {errors.name}
                                </p>
                                )}
                            </div>

                            {/* Deskripsi */}
                            <div>
                                <label htmlFor="description"
                                    className="block text-sm font-semibold text-gray-700 mb-2">
                                    Deskripsi Lomba
                                </label>
                                <textarea id="description" name="description" value={formData.description}
                                    onChange={handleInputChange} rows="5"
                                    placeholder="Jelaskan detail lomba, kategori yang dilombakan, persyaratan peserta, dll."
                                    className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent transition resize-none" />
                                <p className="mt-1 text-xs text-gray-500">Opsional - Berikan informasi detail tentang
                                    lomba</p>
                            </div>

                            {/* Tanggal Pendaftaran */}
                            <div className="grid md:grid-cols-2 gap-6">
                                {/* Start Date */}
                                <div>
                                    <label htmlFor="registration_start_date"
                                        className="block text-sm font-semibold text-gray-700 mb-2">
                                        Tanggal Mulai Pendaftaran <span className="text-red-600">*</span>
                                    </label>
                                    <input type="datetime-local" id="registration_start_date"
                                        name="registration_start_date" value={formData.registration_start_date}
                                        onChange={handleInputChange} className={`w-full px-4 py-3 border rounded-lg
                                        focus:ring-2 focus:ring-red-900 focus:border-transparent transition ${
                                        errors.registration_start_date ? 'border-red-500' : 'border-gray-300' }`} />
                                    {errors.registration_start_date && (
                                    <p className="mt-2 text-sm text-red-600 flex items-center">
                                        <span className="mr-1">⚠</span> {errors.registration_start_date}
                                    </p>
                                    )}
                                </div>

                                {/* End Date */}
                                <div>
                                    <label htmlFor="registration_end_date"
                                        className="block text-sm font-semibold text-gray-700 mb-2">
                                        Tanggal Akhir Pendaftaran <span className="text-red-600">*</span>
                                    </label>
                                    <input type="datetime-local" id="registration_end_date"
                                        name="registration_end_date" value={formData.registration_end_date}
                                        onChange={handleInputChange} className={`w-full px-4 py-3 border rounded-lg
                                        focus:ring-2 focus:ring-red-900 focus:border-transparent transition ${
                                        errors.registration_end_date ? 'border-red-500' : 'border-gray-300' }`} />
                                    {errors.registration_end_date && (
                                    <p className="mt-2 text-sm text-red-600 flex items-center">
                                        <span className="mr-1">⚠</span> {errors.registration_end_date}
                                    </p>
                                    )}
                                </div>
                            </div>

                            {/* Status */}
                            <div>
                                <label htmlFor="status" className="block text-sm font-semibold text-gray-700 mb-2">
                                    Status Lomba <span className="text-red-600">*</span>
                                </label>
                                <select id="status" name="status" value={formData.status}
                                    onChange={handleInputChange}
                                    className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent transition bg-white">
                                    <option value="akan_datang">Akan Datang</option>
                                    <option value="dibuka">Dibuka</option>
                                    <option value="ditutup">Ditutup</option>
                                    <option value="selesai">Selesai</option>
                                </select>
                                <p className="mt-1 text-xs text-gray-500">Pilih status awal lomba</p>
                            </div>

                            {/* Info Box */}
                            <div className="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                                <div className="flex">
                                    <div className="flex-shrink-0">
                                        <svg className="h-5 w-5 text-blue-500" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fillRule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clipRule="evenodd" />
                                        </svg>
                                    </div>
                                    <div className="ml-3">
                                        <p className="text-sm text-blue-700">
                                            <strong>Tips:</strong> Pastikan tanggal pendaftaran dibuka cukup lama untuk
                                            memberikan waktu peserta mendaftar.
                                            Biasanya periode pendaftaran minimal 2 minggu.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {/* Action Buttons */}
                            <div className="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                                <button type="button" onClick={handleCancel}
                                    className="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold">
                                    Batal
                                </button>
                                <button type="submit"
                                    className="px-6 py-3 bg-red-900 text-white rounded-lg hover:bg-red-800 transition font-semibold flex items-center">
                                    <Plus className="h-5 w-5 mr-2" />
                                    Simpan Lomba
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {/* Preview Card */}
                <div className="mt-6 bg-gradient-to-r from-red-900 to-orange-800 rounded-xl p-6 text-white">
                    <h3 className="text-lg font-bold mb-4">Preview Data Lomba</h3>
                    <div className="bg-white bg-opacity-20 rounded-lg p-4 backdrop-blur">
                        <div className="grid md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p className="text-gray-200 mb-1">Nama Lomba:</p>
                                <p className="font-semibold">{formData.name || '-'}</p>
                            </div>
                            <div>
                                <p className="text-gray-200 mb-1">Status:</p>
                                <p className="font-semibold capitalize">{formData.status.replace('_', ' ')}</p>
                            </div>
                            <div>
                                <p className="text-gray-200 mb-1">Mulai Pendaftaran:</p>
                                <p className="font-semibold">
                                    {formData.registration_start_date
                                    ? new Date(formData.registration_start_date).toLocaleString('id-ID', {
                                    day: 'numeric',
                                    month: 'long',
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                    })
                                    : '-'
                                    }
                                </p>
                            </div>
                            <div>
                                <p className="text-gray-200 mb-1">Akhir Pendaftaran:</p>
                                <p className="font-semibold">
                                    {formData.registration_end_date
                                    ? new Date(formData.registration_end_date).toLocaleString('id-ID', {
                                    day: 'numeric',
                                    month: 'long',
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                    })
                                    : '-'
                                    }
                                </p>
                            </div>
                            {formData.description && (
                            <div className="md:col-span-2">
                                <p className="text-gray-200 mb-1">Deskripsi:</p>
                                <p className="font-semibold">{formData.description}</p>
                            </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    );
    };

    // User Dashboard
    const UserDashboard = () => (
    <div className="min-h-screen bg-gray-100">
        {/* User Navbar */}
        <nav className="bg-white shadow">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between items-center h-16">
                    <div className="flex items-center">
                        <Trophy className="h-8 w-8 text-red-900" />
                        <span className="ml-2 text-xl font-bold text-red-900">Dashboard Peserta</span>
                    </div>
                    <div className="hidden md:flex items-center space-x-6">
                        <a href="#" className="text-red-900 font-semibold">Lomba</a>
                        <a href="#" className="text-gray-600 hover:text-red-900">Jadwal</a>
                        <a href="#" className="text-gray-600 hover:text-red-900">Klasemen</a>
                        <a href="#" className="text-gray-600 hover:text-red-900">Profil</a>
                    </div>
                    <div className="flex items-center space-x-4">
                        <Bell className="h-6 w-6 text-gray-600 cursor-pointer hover:text-red-900" />
                        <div className="flex items-center space-x-2">
                            <div
                                className="w-10 h-10 bg-red-900 rounded-full flex items-center justify-center text-white font-bold">
                                P
                            </div>
                            <span className="hidden md:block">Peserta</span>
                        </div>
                        <button onClick={()=> setCurrentView('landing')} className="text-gray-600 hover:text-red-900">
                            <LogOut className="h-5 w-5" />
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <div className="max-w-7xl mx-auto px-4 py-8">
            {/* Welcome Banner */}
            <div className="bg-gradient-to-r from-red-900 to-orange-800 rounded-xl p-8 mb-8 text-white">
                <h1 className="text-3xl font-bold mb-2">Selamat Datang, Atlet Silat!</h1>
                <p className="text-gray-200">Kelola pendaftaran lomba dan pantau jadwal pertandingan Anda</p>
            </div>

            <div className="grid md:grid-cols-3 gap-6 mb-8">
                {[
                { title: 'Lomba Terdaftar', value: '2', color: 'bg-blue-500' },
                { title: 'Pertandingan Akan Datang', value: '3', color: 'bg-green-500' },
                { title: 'Medali', value: '1', color: 'bg-yellow-500' }
                ].map((stat, idx) => (
                <div key={idx} className="bg-white rounded-xl shadow p-6">
                    <p className="text-gray-500 text-sm mb-2">{stat.title}</p>
                    <p className="text-4xl font-bold">{stat.value}</p>
                </div>
                ))}
            </div>

            {/* Lomba Tersedia */}
            <div className="bg-white rounded-xl shadow mb-8">
                <div className="p-6 border-b border-gray-200">
                    <h2 className="text-xl font-bold">Lomba Tersedia</h2>
                </div>
                <div className="p-6">
                    <div className="space-y-4">
                        {[
                        { nama: 'Kejuaraan Nasional Silat 2025', tanggal: '15-17 Oktober 2025', lokasi: 'Jakarta',
                        kategori: 'Tanding & Seni', batas: '10 Oktober 2025' },
                        { nama: 'Piala Gubernur Jawa Tengah', tanggal: '5-7 November 2025', lokasi: 'Semarang',
                        kategori: 'Tanding', batas: '30 Oktober 2025' },
                        { nama: 'Festival Silat Nusantara', tanggal: '1-3 Desember 2025', lokasi: 'Surabaya', kategori:
                        'Seni', batas: '25 November 2025' }
                        ].map((lomba, idx) => (
                        <div key={idx} className="border border-gray-200 rounded-lg p-6 hover:shadow-md transition">
                            <div className="flex justify-between items-start mb-4">
                                <div>
                                    <h3 className="text-lg font-bold mb-2">{lomba.nama}</h3>
                                    <div className="space-y-1 text-sm text-gray-600">
                                        <p className="flex items-center">
                                            <Calendar className="h-4 w-4 mr-2" /> {lomba.tanggal}
                                        </p>
                                        <p className="flex items-center">
                                            <Trophy className="h-4 w-4 mr-2" /> {lomba.lokasi}
                                        </p>
                                        <p>Kategori: {lomba.kategori}</p>
                                        <p className="text-red-600 font-semibold">Batas Pendaftaran: {lomba.batas}</p>
                                    </div>
                                </div>
                                <button
                                    className="px-6 py-2 bg-red-900 text-white rounded-lg hover:bg-red-800 transition font-semibold">
                                    Daftar
                                </button>
                            </div>
                        </div>
                        ))}
                    </div>
                </div>
            </div>

            {/* Jadwal Pertandingan */}
            <div className="bg-white rounded-xl shadow">
                <div className="p-6 border-b border-gray-200">
                    <h2 className="text-xl font-bold">Jadwal Pertandingan Saya</h2>
                </div>
                <div className="p-6">
                    <div className="overflow-x-auto">
                        <table className="w-full">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Lomba</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Tanggal & Waktu</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Kategori</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Gelanggang</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-200">
                                {[
                                { lomba: 'Kejuaraan Nasional', waktu: '15 Okt 2025, 09:00', kategori: 'Tanding Putra',
                                gelanggang: 'A1', status: 'Akan Datang' },
                                { lomba: 'Kejuaraan Nasional', waktu: '16 Okt 2025, 14:00', kategori: 'Seni Tunggal',
                                gelanggang: 'B2', status: 'Akan Datang' }
                                ].map((jadwal, idx) => (
                                <tr key={idx} className="hover:bg-gray-50">
                                    <td className="px-6 py-4 font-medium">{jadwal.lomba}</td>
                                    <td className="px-6 py-4 text-gray-600">{jadwal.waktu}</td>
                                    <td className="px-6 py-4 text-gray-600">{jadwal.kategori}</td>
                                    <td className="px-6 py-4 text-gray-600">{jadwal.gelanggang}</td>
                                    <td className="px-6 py-4">
                                        <span
                                            className="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                            {jadwal.status}
                                        </span>
                                    </td>
                                </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    );

    return (
    <div>
        {currentView === 'landing' &&
        <LandingPage />}
        {currentView === 'admin' &&
        <AdminDashboard />}
        {currentView === 'admin-add-lomba' &&
        <AddLombaForm />}
        {currentView === 'user' &&
        <UserDashboard />}

        {/* View Selector (for demo) */}
        <div className="fixed bottom-4 right-4 bg-white rounded-lg shadow-lg p-4 z-50">
            <p className="text-xs text-gray-500 mb-2 font-semibold">Demo Navigation:</p>
            <div className="space-y-2">
                <button onClick={()=> setCurrentView('landing')}
                    className={`block w-full text-left px-3 py-2 rounded ${currentView === 'landing' ? 'bg-red-900
                    text-white' : 'bg-gray-100 hover:bg-gray-200'} text-sm`}
                    >
                    Landing Page
                </button>
                <button onClick={()=> setCurrentView('admin')}
                    className={`block w-full text-left px-3 py-2 rounded ${currentView === 'admin' ? 'bg-red-900
                    text-white' : 'bg-gray-100 hover:bg-gray-200'} text-sm`}
                    >
                    Admin Dashboard
                </button>
                <button onClick={()=> setCurrentView('admin-add-lomba')}
                    className={`block w-full text-left px-3 py-2 rounded ${currentView === 'admin-add-lomba' ?
                    'bg-red-900 text-white' : 'bg-gray-100 hover:bg-gray-200'} text-sm`}
                    >
                    Tambah Lomba
                </button>
                <button onClick={()=> setCurrentView('user')}
                    className={`block w-full text-left px-3 py-2 rounded ${currentView === 'user' ? 'bg-red-900
                    text-white' : 'bg-gray-100 hover:bg-gray-200'} text-sm`}
                    >
                    User Dashboard
                </button>
            </div>
        </div>
    </div>
    );
    };

    export default SilatCompetitionUI;
