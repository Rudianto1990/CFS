<?php
ob_start();
// call library
require_once ('config.php' );
//require_once ($CONF['root.dir'] . 'Libraries/nusoap/nusoap.php' );
require_once ($CONF['root.dir'] . 'Libraries/nusoap-lokal/lib/nusoap.php');
require_once ($CONF['root.dir'] . 'Libraries/xml2array.php' );

// create instance sdf
$server = new soap_server();

// initialize WSDL support
$server->configureWSDL('CFSwsdl', 'http://services.beacukai.go.id/');

// place schema at namespace with prefix tns
$server->wsdl->schemaTargetNamespace = 'http://services.beacukai.go.id/';

$server->register('CoCoTangki', // method name
	array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'), // input parameter
	array('CoCoTangkiResult' => 'xsd:string'), // output
	'http://services.beacukai.go.id/', // namespace
	'http://services.beacukai.go.id/CoCoTangki', // soapaction
	'rpc', // style
	'encoded', // use
	'Fungsi untuk melakukan uji coba insert data Coarri Tangki-tangki penimbunan'// documentation
);

$server->register('CoarriCodeco_Container',
	array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
	array('CoarriCodeco_ContainerResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/CoarriCodeco_Container',
	'rpc',
	'encoded',
	'Fungsi untuk insert data Coarri-Codeco Container(Baru, dengan penambahan kolom pada detil container)'
);

$server->register('CoarriCodeco_Kemasan',
	array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
	array('CoarriCodeco_KemasanResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/CoarriCodeco_Kemasan',
	'rpc',
	'encoded',
	'Fungsi untuk insert data Coarri Kemasan (Baru, dengan penambahan kolom pada detil kemasan)'
);

$server->register('ConfirmTagihanPLP',
	array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
	array('ConfirmTagihanPLPResult' => 'xsd:string'),
	'urn:ConfirmTagihanPLPwsdl',
	'urn:TPSServices',
	'rpc',
	'encoded',
	'Fungsi untuk Confirm Tagihan PLP from TPS'
);

$server->register('ConfirmTagihanPenimbunan',
	array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
	array('ConfirmTagihanPenimbunanResult' => 'xsd:string'),
	'urn:ConfirmTagihanPenimbunanwsdl',
	'urn:TPSServices',
	'rpc',
	'encoded',
	'Fungsi untuk Confirm Tagihan Penimbunan from TPS'
);

$server->register('GetBC23Permit',
	array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_Gudang' => 'xsd:string'),
	array('GetBC23PermitResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/GetBC23Permit',
	'rpc',
	'encoded',
	'Fungsi untuk mendownload data SPPB, filter yang digunakan adalah kode Gudang'
);

$server->register('GetBC23Permit_FASP',
	array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_ASP' => 'xsd:string'),
	array('GetBC23Permit_FASPResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/GetBC23Permit_FASP',
	'rpc',
	'encoded',
	'Fungsi untuk mendownload data SPPB, filter yang digunakan adalah kode ASP'
);

$server->register('GetDataBilling',
	array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
	array('GetDataBillingResult' => 'xsd:string'),
	'urn:GetDataBillingwsdl',
	'urn:TPSServices',
	'rpc',
	'encoded',
	'Fungsi untuk get data billing untuk digenerate portal CFS'
);

$server->register('GetDataOB',
	array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_ASP' => 'xsd:string'),
	array('GetDataOBResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/GetDataOB',
	'rpc',
	'encoded',
	'Fungsi untuk mendownload data OB/Pindah TPS, filter yang digunakan adalah kode ASP'
);

$server->register('GetDokumenManual',
	array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_Tps' => 'xsd:string'),
	array('GetDokumenManualResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/GetDokumenManual',
	'rpc',
	'encoded',
	'Fungsi untuk mendownload data dokumen manual'
);

$server->register('GetDokumenPabeanPermit_FASP',
	array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_Tps' => 'xsd:string'),
	array('GetDokumenPabeanPermit_FASPResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/GetDokumenPabeanPermit_FASP',
	'rpc',
	'encoded',
	'Fungsi untuk mendownload data dokumen manual'
);

$server->register('GetImporPermit',
	array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_Gudang' => 'xsd:string'),
	array('GetImporPermitResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/GetImporPermit',
	'rpc',
	'encoded',
	'Fungsi untuk mendownload data SPPB, filter yang digunakan adalah kode Gudang'
);

$server->register('GetImporPermit_FASP',
	array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_ASP' => 'xsd:string'),
	array('GetImporPermit_FASPResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/GetImporPermit_FASP',
	'rpc',
	'encoded',
	'Fungsi untuk mendownload data SPPB, filter yang digunakan adalah kode ASP'
);

$server->register('GetImporPermit_Manual',
	array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_Gudang' => 'xsd:string'),
	array('GetImporPermit_ManualResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/GetImporPermit_Manual',
	'rpc',
	'encoded',
	'Fungsi untuk mendownload data SPPB yang di entry manual dari CFS Portal, filter yang digunakan adalah kode Gudang'
);

$server->register('GetImpor_Sppb',
	array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'No_Sppb' => 'xsd:string', 'Tgl_Sppb' => 'xsd:string', 'NPWP_Imp' => 'xsd:string'),
	array('GetImpor_SppbResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/GetImpor_Sppb',
	'rpc',
	'encoded',
	'Fungsi untuk mendownload data SPPB, filter yang digunakan adalah tanggal SPPB, nomor SPPB dan NPWP, format tanggal #ddmmyyyy#'
);

$server->register('GetPermohonanCFS',
	array('username' => 'xsd:string', 'password' => 'xsd:string'),
	array('return' => 'xsd:string'),
	'urn:GetPermohonanCFSwsdl',
	'urn:TPSOnline',
	'rpc',
	'encoded',
	'GetPermohonanCFS'
);

$server->register('GetRejectData',
	array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_Tps' => 'xsd:string'),
	array('GetRejectDataResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/GetRejectData',
	'rpc',
	'encoded',
	'Fungsi untuk mendownload data REJECT hasil validasi konten'
);

$server->register('GetResponBatalPLP',
	array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_asp' => 'xsd:string'),
	array('GetResponBatalPLPResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/GetResponBatalPLP',
	'rpc',
	'encoded',
	'Fungsi untuk mengambil data persetujuan pembatalan PLP'
);

$server->register('GetResponBatalPLPTujuan',
	array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_asp' => 'xsd:string'),
	array('GetResponBatalPLPTujuanResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/GetResponBatalPLPTujuan',
	'rpc',
	'encoded',
	'Fungsi untuk mengambil data persetujuan pembatalan PLP'
);

$server->register('GetResponPLP',
	array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_asp' => 'xsd:string'),
	array('GetResponPLPResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/GetResponPLP',
	'rpc',
	'encoded',
	'Fungsi untuk mendownload data Respon PLP yang sudah diproses, filter yang digunakan adalah kode TPS'
);

$server->register('GetResponPLPTujuan',
	array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_asp' => 'xsd:string'),
	array('GetResponPLPTujuanResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/GetResponPLPTujuan',
	'rpc',
	'encoded',
	'Fungsi untuk mendownload data Respon PLP yang sudah disetujui, oleh TPS Tujuan, filter yang digunakan adalah kode TPS'
);

$server->register('GetResponPLP_Tujuan',
	array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_asp' => 'xsd:string'),
	array('GetResponPLP_TujuanResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/GetResponPLP_Tujuan',
	'rpc',
	'encoded',
	'Fungsi untuk mendownload data Respon PLP yang sudah disetujui, oleh TPS Tujuan, filter yang digunakan adalah kode TPS'
);

$server->register('GetResponPembayaranCFS',
	array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_Gudang' => 'xsd:string'),
	array('GetResponPembayaranCFSResult' => 'xsd:string'),
	'urn:GetResponPembayaranCFSwsdl',
	'urn:TPSServices',
	'rpc',
	'encoded',
	'Fungsi untuk download data billing CFS yang sudah melunasi tagihan, filter yang digunakan adalah kode GUDANG'
);

$server->register('GetSPJM',
	array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_Tps' => 'xsd:string'),
	array('GetSPJMResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/GetSPJM',
	'rpc',
	'encoded',
	'Fungsi untuk mendownload data barang yang terkena SPJM dengan parameter KD TPS'
);

$server->register('GetSPJM_onDemand',
	array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'noPib' => 'xsd:string', 'tglPib' => 'xsd:string'),
	array('GetSPJM_onDemandResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/GetSPJM_onDemand',
	'rpc',
	'encoded',
	'Fungsi untuk mendownload data barang yang terkena SPJM dengan filter No.PIB dan Tgl. PIB format ddmmyyyy'
);

$server->register('GetSppb_Bc23',
	array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'No_Sppb' => 'xsd:string', 'Tgl_Sppb' => 'xsd:string', 'NPWP_Imp' => 'xsd:string'),
	array('GetSppb_Bc23Result' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/GetSppb_Bc23',
	'rpc',
	'encoded',
	'Fungsi untuk mendownload data SPPB BC23, filter yang digunakan adalah tanggal SPPB, nomor SPPB dan NPWP, format tanggal #ddmmyyyy#'
);

$server->register('GetSubTotal_Billing',
	array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
	array('GetSubTotal_BillingResult' => 'xsd:string'),
	'urn:GetSubTotal_Billingwsdl',
	'urn:TPSServices',
	'rpc',
	'encoded',
	'Fungsi untuk get data billing from TPS'
);

$server->register('HelloWorld',
	array('String0' => 'xsd:string'),
	array('return' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/HelloWorld',
	'rpc',
	'encoded',
	'HelloWorld'
);

$server->register('LoadBilling',
	array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
	array('LoadBillingResult' => 'xsd:string'),
	'urn:LoadBillingwsdl',
	'urn:TPSServices',
	'rpc',
	'encoded',
	'Fungsi untuk get data billing from TPS'
);

$server->register('LoadBillingGudang',
	array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
	array('LoadBillingGudangResult' => 'xsd:string'),
	'urn:LoadBillingGudangwsdl',
	'urn:TPSServices#LoadBillingGudang',
	'rpc',
	'encoded',
	'Fungsi untuk pengiriman data billing dari Gudang'
);

$server->register('OrderPengeluaranBarang',
	array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
	array('OrderPengeluaranBarangResult' => 'xsd:string'),
	'urn:OrderPengeluaranBarangwsdl',
	'urn:TPSServices',
	'rpc',
	'encoded',
	'Fungsi untuk Order Pengeluaran Barang from TPS'
);

$server->register('ReceiveBC23Permit',
	array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_Gudang' => 'xsd:string', 'fStream' => 'xsd:string'),
	array('ReceiveBC23PermitResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/ReceiveBC23Permit',
	'rpc',
	'encoded',
	'Fungsi untuk pengiriman data SPPB BC 2.3 ke CFS Portal, merujuk kepada service GetBC23Permit'
);

$server->register('ReceiveBC23Permit_FASP',
	array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_ASP' => 'xsd:string', 'fStream' => 'xsd:string'),
	array('ReceiveBC23Permit_FASPResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/ReceiveBC23Permit_FASP',
	'rpc',
	'encoded',
	'Fungsi untuk pengiriman data SPPB BC 2.3 ke CFS Portal, merujuk kepada service GetBC23Permit_FASP'
);

$server->register('ReceiveImporPermit',
	array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_Gudang' => 'xsd:string', 'fStream' => 'xsd:string'),
	array('ReceiveImporPermitResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/ReceiveImporPermit',
	'rpc',
	'encoded',
	'Fungsi untuk pengiriman data SPPB ke CFS Portal, merujuk kepada service GetImporPermit'
);

$server->register('ReceiveImporPermit_FASP',
	array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_ASP' => 'xsd:string', 'fStream' => 'xsd:string'),
	array('ReceiveImporPermit_FASPResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/ReceiveImporPermit_FASP',
	'rpc',
	'encoded',
	'Fungsi untuk pengiriman data SPPB ke CFS Portal, merujuk kepada service GetImporPermit_FASP'
);

$server->register('ReceiveImpor_Sppb',
	array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'No_Sppb' => 'xsd:string', 'Tgl_Sppb' => 'xsd:string', 'NPWP_Imp' => 'xsd:string', 'fStream' => 'xsd:string'),
	array('ReceiveImpor_SppbResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/ReceiveImpor_Sppb',
	'rpc',
	'encoded',
	'Fungsi untuk pengiriman data SPPB ke CFS Portal, merujuk kepada service GetImporPermit_Sppb'
);

$server->register('ReceiveResponBatalPLP',
	array('fStream' => 'xsd:string', 'UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_asp' => 'xsd:string'),
	array('ReceiveResponBatalPLPResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/ReceiveResponBatalPLP',
	'rpc',
	'encoded',
	'Fungsi untuk pengiriman data persetujuan pembatalan PLP oleh TPS asal ke CFS Portal'
);

$server->register('ReceiveResponBatalPLPTujuan',
	array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_asp' => 'xsd:string', 'fStream' => 'xsd:string'),
	array('ReceiveResponBatalPLPTujuanResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/ReceiveResponBatalPLPTujuan',
	'rpc',
	'encoded',
	'Fungsi untuk pengiriman data persetujuan pembatalan PLP oleh TPS tujuan ke CFS Portal'
);

$server->register('ReceiveResponPLP',
	array('fStream' => 'xsd:string', 'UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_asp' => 'xsd:string'),
	array('ReceiveResponPLPResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/ReceiveResponPLP',
	'rpc',
	'encoded',
	'Fungsi untuk pengiriman data persetujuan PLP oleh TPS asal ke CFS Portal'
);

$server->register('ReceiveResponPLP_Tujuan',
	array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_asp' => 'xsd:string', 'fStream' => 'xsd:string'),
	array('ReceiveResponPLP_TujuanResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/ReceiveResponPLP_Tujuan',
	'rpc',
	'encoded',
	'Fungsi untuk pengiriman data persetujuan PLP oleh TPS Tujuan ke CFS Portal'
);

$server->register('ReceiveSPJM',
	array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_Tps' => 'xsd:string', 'fStream' => 'xsd:string'),
	array('ReceiveSPJMResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/ReceiveSPJM',
	'rpc',
	'encoded',
	'Fungsi untuk pengiriman data barang yang terkena SPJM ke CFS Portal, merujuk kepada service GetSPJM'
);

$server->register('ReceiveSPJM_onDemand',
	array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'noPib' => 'xsd:string', 'tglPib' => 'xsd:string', 'fStream' => 'xsd:string'),
	array('ReceiveSPJM_onDemandResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/ReceiveSPJM_onDemand',
	'rpc',
	'encoded',
	'Fungsi untuk pengiriman data barang yang terkena SPJM ke CFS Portal, merujuk kepada service GetSPJM_onDemand'
);

$server->register('ReceiveSppb_Bc23',
	array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'No_Sppb' => 'xsd:string', 'Tgl_Sppb' => 'xsd:string', 'NPWP_Imp' => 'xsd:string', 'fStream' => 'xsd:string'),
	array('ReceiveSppb_Bc23Result' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/ReceiveSppb_Bc23',
	'rpc',
	'encoded',
	'Fungsi untuk pengiriman data SPPB BC 2.3 ke CFS Portal, merujuk kepada service GetSppb_Bc23'
);

$server->register('UploadBatalPLP',
	array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
	array('UploadBatalPLPResult' => 'xsd:string'),
	'http://services.beacukai.go.id/',
	'http://services.beacukai.go.id/UploadBatalPLP',
	'rpc',
	'encoded',
	'Fungsi untuk Upload data pembatalan PLP '
);

$server->register('UploadCustomerData',
	array('fStream' => 'xsd:string', 'Type' => 'xsd:string'),
	array('UploadCustomerDataResult' => 'xsd:string'),
	'urn:UploadCustomerDatawsdl',
	'urn:TPSServices#UploadCustomerData',
	'rpc',
	'encoded',
	'Fungsi untuk Upload data Costumer dari CDM ke CFS Portal '
);

$server->register('UploadMohonPLP',
	array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
	array('UploadMohonPLPResult' => 'xsd:string'),
	'http://services.beacukai.go.id/', 
	'http://services.beacukai.go.id/UploadMohonPLP',
	'rpc',
	'encoded',
	'Fungsi untuk Upload data permohonan PLP '
);

$server->register('ValidasiEDC',
	array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
	array('ValidasiEDCPLPResult' => 'xsd:string'),
	'urn:ValidasiEDCwsdl',
	'urn:TPSServices',
	'rpc',
	'encoded',
	'Fungsi untuk Validasi Pembayaran dari engine EDC from TPS'
);

$server->register('ValidasiTagihanPLP',
	array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
	array('ValidasimTagihanPLPResult' => 'xsd:string'),
	'urn:ValidasiTagihanPLPwsdl',
	'urn:TPSServices',
	'rpc',
	'encoded',
	'Fungsi untuk Validasi Tagihan PLP from TPS'
);

$server->register('ValidasiTagihanPenimbunan',
	array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
	array('ValidasiTagihanPenimbunanResult' => 'xsd:string'), // output
	'urn:ValidasiTagihanPenimbunanwsdl',
	'urn:TPSServices',
	'rpc',
	'encoded',
	'Fungsi untuk Validasi Tagihan Penimbunan from TPS'
);

$server->register('WSBillingGudang',
	array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_Gudang' => 'xsd:string'),
	array('WSBillingGudangResult' => 'xsd:string'),
	'urn:WSBillingGudangwsdl',
	'urn:TPSServices',
	'rpc',
	'encoded',
	'Fungsi untuk download data billing CFS yang sudah melunasi tagihan dengan detil item billing, filter yang digunakan adalah kode GUDANG'
);

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

function HelloWorld($string0) {
    return "Hello " . $string0 . ", Good day.";
}

function UploadCustomerData($fStream, $Type) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices("CDM", $Type, $WSDLSOAP, 'UploadCustomerData', $fStream);

    $STR_DATA = str_replace('&', '&amp;', $fStream);
    $message = '';$mess = array();
    $xml = xml2ary($STR_DATA);
    if (count($xml) > 0) {
        $xml = $xml['DOCUMENT']['_c'];
        $countCDM = 0;
        $countCDM = count($xml['CDM']);
        if ($countCDM > 1) {
            for ($c = 0; $c < $countCDM; $c++) {
                $CDM = $xml['CDM'][$c]['_c'];
                $mess[] = insertCDM($CDM, $Type, $IDLogServices);
            }
			$vals = array_count_values($mess);
			$message = 'Berhasil insert: '.$vals[1]." dari ".count($countCDM).' data';
        } elseif ($countCDM == 1) {
            $CDM = $xml['CDM']['_c'];
            $messa = insertCDM($CDM, $Type, $IDLogServices);
			if($messa == 1){
				$message = 'Berhasil insert data';
			}else{
				$message = 'Gagal insert data';
			}
        } else {
			$message = 'Format fStream SALAH!!!';
        }
    } else {
        $message = 'Format fStream SALAH!!!';
    }
    $return = $message; //"Proses Berhasil Tersimpan di Portal CFS";//$message;
    updateLogServices($IDLogServices, $return);

    $conn->disconnect();
    return $return;
}

function GetRejectData($UserName, $Password, $Kd_Tps) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($UserName, $Password, $CONF['url.wsdl'], 'GetRejectData', $Kd_Tps);

    $SOAPAction = 'http://services.beacukai.go.id/GetRejectData';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetRejectData xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $UserName . '</UserName>
                  <Password>' . $Password . '</Password>
                  <Kd_Tps>' . $Kd_Tps . '</Kd_Tps>
                </GetRejectData>
              </soap:Body>
            </soap:Envelope>';
			
    $cek = cek_go_live($Username);
    if ($cek == "T") {
		$cek = checkUser($Username,$Password);
		if (!$cek['return']) {
			return $cek['message'];
		}
        $return = "Username Anda Berstatus Non Live Bea Cukai. Data tidak diteruskan ke Bea Cukai.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }
	
    if ($Send['response'] != '') {
        $arr1 = 'GetRejectDataResponse';
        $arr2 = 'GetRejectDataResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = 'Failed to get response from BC';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetDataOB($UserName, $Password, $Kd_ASP) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($UserName, $Password, $CONF['url.wsdl'], 'GetDataOB', $Kd_ASP);

    $SOAPAction = 'http://services.beacukai.go.id/GetDataOB';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetDataOB xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $UserName . '</UserName>
                  <Password>' . $Password . '</Password>
                  <Kd_ASP>' . $Kd_ASP . '</Kd_ASP>
                </GetDataOB>
              </soap:Body>
            </soap:Envelope>';

    $cek = cek_go_live($Username);
    if ($cek == "T") {
		$cek = checkUser($Username,$Password);
		if (!$cek['return']) {
			return $cek['message'];
		}
        $return = "Username Anda Berstatus Non Live Bea Cukai. Data tidak diteruskan ke Bea Cukai.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }
    
	if ($Send['response'] != '') {
        $arr1 = 'GetDataOBResponse';
        $arr2 = 'GetDataOBResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = 'Failed to get response from BC';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetDokumenPabeanPermit_FASP($UserName, $Password, $Kd_Tps) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($UserName, $Password, $CONF['url.wsdl'], 'GetDokumenPabeanPermit_FASP', $Kd_Tps);

    $SOAPAction = 'http://services.beacukai.go.id/GetDokumenPabeanPermit_FASP';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetDokumenPabeanPermit_FASP xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $UserName . '</UserName>
                  <Password>' . $Password . '</Password>
                  <Kd_Tps>' . $Kd_Tps . '</Kd_Tps>
                </GetDokumenPabeanPermit_FASP>
              </soap:Body>
            </soap:Envelope>';

    $cek = cek_go_live($Username);
    if ($cek == "T") {
		$cek = checkUser($Username,$Password);
		if (!$cek['return']) {
			return $cek['message'];
		}
        $return = "Username Anda Berstatus Non Live Bea Cukai. Data tidak diteruskan ke Bea Cukai.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }

    if ($Send['response'] != '') {
        $arr1 = 'GetDokumenPabeanPermit_FASPResponse';
        $arr2 = 'GetDokumenPabeanPermit_FASPResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = 'Failed to get response from BC';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetDokumenManual($UserName, $Password, $Kd_Tps) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($UserName, $Password, $CONF['url.wsdl'], 'GetDokumenManual', $Kd_Tps);

    $SOAPAction = 'http://services.beacukai.go.id/GetDokumenManual';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetDokumenManual xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $UserName . '</UserName>
                  <Password>' . $Password . '</Password>
                  <Kd_Tps>' . $Kd_Tps . '</Kd_Tps>
                </GetDokumenManual>
              </soap:Body>
            </soap:Envelope>';

	$cek = cek_go_live($Username);
    if ($cek == "T") {
		$cek = checkUser($Username,$Password);
		if (!$cek['return']) {
			return $cek['message'];
		}
        $return = "Username Anda Berstatus Non Live Bea Cukai. Data tidak diteruskan ke Bea Cukai.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }

    if ($Send['response'] != '') {
        $arr1 = 'GetDokumenManualResponse';
        $arr2 = 'GetDokumenManualResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = 'Failed to get response from BC';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function UploadMohonPLP($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'UploadMohonPLP', $fStream);

    $SOAPAction = 'http://services.beacukai.go.id/UploadMohonPLP';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <UploadMohonPLP xmlns="http://services.beacukai.go.id/">
                  <fStream>' . htmlspecialchars($fStream) . '</fStream>
                  <Username>' . $Username . '</Username>
                  <Password>' . $Password . '</Password>
                </UploadMohonPLP>
              </soap:Body>
            </soap:Envelope>';

	$cek = cek_go_live($Username);
    if ($cek == "T") {
		$cek = checkUser($Username,$Password);
		if (!$cek['return']) {
			return $cek['message'];
		}
        $return = "Proses Berhasil Tersimpan di Portal CFS, Data tidak diteruskan ke BC.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }

    if ($Send['response'] != '') {
        $arr1 = 'UploadMohonPLPResponse';
        $arr2 = 'UploadMohonPLPResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = 'Failed to get response from BC';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetResponPLP($UserName, $Password, $Kd_asp) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($UserName, $Password, $CONF['url.wsdl'], 'GetResponPLP', $Kd_asp);

    $SOAPAction = 'http://services.beacukai.go.id/GetResponPLP';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetResponPLP xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $UserName . '</UserName>
                  <Password>' . $Password . '</Password>
                  <Kd_asp>' . $Kd_asp . '</Kd_asp>
                </GetResponPLP>
              </soap:Body>
            </soap:Envelope>';

    $cek = cek_go_live($UserName);
    if ($cek == "T") {
        $return = '<?xml version="1.0" encoding="UTF-8" ?>
		<DOCUMENT>
		<RESPONPLP> 
		<HEADER><DEMO>DEMO DATA</DEMO>
		<KD_KANTOR>040300</KD_KANTOR>
		<KD_TPS>PLDC</KD_TPS>
		<REF_NUMBER>REFF123</REF_NUMBER>
		<NO_PLP>PLP123</NO_PLP>
		<TGL_PLP>20170727</TGL_PLP>
		< ALASAN_TOLAK ></ALASAN_TOLAK>
		</HEADER>
		<DETIL>
		<CONT>
		<NO_CONT>OOLU12345</NO_CONT>
		<UK_CONT>20</UK_CONT>
		<FL_SETUJU>Y</FL_SETUJU>
		<JNS_CONT>L</JNS_CONT>
		</CONT>
		<CONT>
		<NO_CONT>OOLU12346</NO_CONT>
		<UK_CONT>20</UK_CONT>
		<FL_SETUJU>Y</FL_SETUJU>
		<JNS_CONT>L</JNS_CONT>
		</CONT>
		</DETIL>
		</RESPONPLP>
		</DOCUMENT>';
		$cek = checkUser($Username,$Password);
		if (!$cek['return']) {
			return $cek['message'];
		}
        $return = "Username Anda Berstatus Non Live Bea Cukai. Data tidak diteruskan ke Bea Cukai.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }
    if ($Send['response'] != '') {
        $arr1 = 'GetResponPLPResponse';
        $arr2 = 'GetResponPLPResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = 'Failed to get response from BC';
    }
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function ReceiveResponPLP($fStream, $Username, $Password, $Kd_asp) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ReceiveResponPLP', $Kd_asp);
	$cek = checkUser($Username,$Password);
	if (!$cek['return']) {
		return $cek['message'];
	}
	$return = "Proses Berhasil Tersimpan di CFS Portal.";
    updateLogServices($IDLogServices, $fStream);
    $conn->disconnect();
    return $return;
}

function GetResponPLP_Tujuan($UserName, $Password, $Kd_asp) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($UserName, $Password, $CONF['url.wsdl'], 'GetResponPLP_Tujuan', $Kd_asp);

    $SOAPAction = 'http://services.beacukai.go.id/GetResponPLP_Tujuan';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetResponPLP_Tujuan xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $UserName . '</UserName>
                  <Password>' . $Password . '</Password>
                  <Kd_asp>' . $Kd_asp . '</Kd_asp>
                </GetResponPLP_Tujuan>
              </soap:Body>
            </soap:Envelope>';
    $cek = cek_go_live($UserName);
    if ($cek == "T" && ($UserName!='PLDC' && $UserName!='MTI')) {
        $return = '<?xml version="1.0" encoding="UTF-8" ?>
		<DOCUMENT>
		<RESPONPLP>
		<HEADER><DEMO>DEMO DATA</DEMO>
		<KD_KANTOR>040300</KD_KANTOR>
		<KD_TPS>MTI0</KD_TPS>
		<KD_TPS_ASAL>PLDC</KD_TPS_ASAL>
		<GUDANG_TUJUAN>BAND</GUDANG_TUJUAN>
		<NO_PLP>PLP123</NO_PLP>
		<TGL_PLP>20170727</TGL_PLP>
		<CALL_SIGN>TKL</CALL_SIGN>
		<NM_ANGKUT>TEST KAPAL</NM_ANGKUT>
		<NO_VOY_FLIGHT>T123</NO_VOY_FLIGHT>
		<TGL_TIBA>20170727</TGL_TIBA>
		<NO_SURAT>SR123</NO_SURAT>
		<TGL_SURAT>20170727</TGL_SURAT>
		<NO_BC11>BC11-123</NO_BC11>
		<TGL_BC11>20170727</TGL_BC11>
		</HEADER>
		<DETIL>
		<CONT>
		<NO_CONT>OOLU12345</NO_CONT>
		<UK_CONT>20</UK_CONT>
		<JNS_CONT>L</JNS_CONT>
		<NO_POS_BC11>040300000001</NO_POS_BC11>
		<CONSIGNEE>CONSIGNEE</CONSIGNEE>
		</CONT>
		<CONT>
		<NO_CONT>OOLU12346</NO_CONT>
		<UK_CONT>20</UK_CONT>
		<JNS_CONT>L</JNS_CONT>
		<NO_POS_BC11>040300000002</NO_POS_BC11>
		<CONSIGNEE>CONSIGNEE</CONSIGNEE>
		</CONT>
		</DETIL>
		</RESPONPLP>
		</DOCUMENT>';
		$cek = checkUser($Username,$Password);
		if (!$cek['return']) {
			return $cek['message'];
		}
        $return = "Username Anda Berstatus Non Live Bea Cukai. Data tidak diteruskan ke Bea Cukai.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }
    if ($Send['response'] != '') {
        $arr1 = 'GetResponPLP_TujuanResponse';
        $arr2 = 'GetResponPLP_TujuanResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = 'Failed to get response from BC';
    }
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function ReceiveResponPLP_Tujuan($Username, $Password, $Kd_asp, $fStream) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ReceiveResponPLP_Tujuan', $Kd_asp);
	$cek = checkUser($Username,$Password);
	if (!$cek['return']) {
		updateLogServices($IDLogServices, $fStream);
		updateLogServicesToFailed($IDLogServices, $cek['message']);
        return $cek['message'];
    }

	$STR_DATA = $fStream;//str_replace('&', '&amp;', $fStream);

	libxml_use_internal_errors(true);

	$doc = simplexml_load_string($STR_DATA); // array object
	$xml = explode("\n", $STR_DATA);
	$return=$STR_DATA;//"";

	if (!$doc) {
		$errors = libxml_get_errors();
		foreach ($errors as $error) {
			$return .= display_xml_error($error, $xml);
		}

		libxml_clear_errors();
	}else{
		/* if($cek['kdorganisasi']=='108'){
			$xml = xml2ary($STR_DATA);
			if (count($xml) > 0) {
				$xml = $xml['DOCUMENT']['_c'];
				$countPLP = count($xml['RESPONPLP']);
				if ($countPLP > 1) {
					for ($c = 0; $c < $countPLP; $c++) {
						$RESPONPLP = $xml['RESPONPLP'][$c]['_c'];
						$retr = InsertPLPResponTujuan($RESPONPLP,$IDLogServices);
						$retr = explode("|",$retr);
						$return = $retr[1];
						if($retr[0]==0){
							$jml_err = 1;
							break;
						}else{
							$jml_err = 0;
						}
					}
					if($jml_err==0) updateLogServicesToSuccess($IDLogServices);
					else updateLogServicesToFailed($IDLogServices, $return);
				} elseif ($countPLP == 1) {
					$RESPONPLP = $xml['RESPONPLP']['_c'];
					$return = InsertPLPResponTujuan($RESPONPLP,$IDLogServices);
					$retr = explode("|",$retr);
					$return = $retr[1];
					if($retr[0]==1) updateLogServicesToSuccess($IDLogServices);
					else updateLogServicesToFailed($IDLogServices, $return);
				}else{
					$return = "Data XML salah.";
					updateLogServicesToFailed($IDLogServices, 'Data XML salah');
				}
			}else{
				$return = "Data XML tidak ada.";
				updateLogServicesToFailed($IDLogServices, 'Data XML tidak ada');
			}
		}else{
			$return = "Proses Berhasil Tersimpan di CFS Portal.";
			updateLogServices($IDLogServices, $fStream);
		}
	 */
		$return = "Proses Berhasil Tersimpan di CFS Portal.";
	}
	updateLogServices($IDLogServices, $fStream);
    $conn->disconnect();
    return $return;
}

function GetResponPLPTujuan($UserName, $Password, $Kd_asp) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($UserName, $Password, $CONF['url.wsdl'], 'GetResponPLPTujuan', $Kd_asp);

    $SOAPAction = 'http://services.beacukai.go.id/GetResponPLPTujuan';
    $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.beacukai.go.id/">
            <soapenv:Header/>
            <soapenv:Body>
               <ser:GetResponPLPTujuan>
                  <!--Optional:-->
                  <ser:UserName>' . $UserName . '</ser:UserName>
                  <!--Optional:-->
                  <ser:Password>' . $Password . '</ser:Password>
                  <!--Optional:-->
                  <ser:Kd_asp>' . $Kd_asp . '</ser:Kd_asp>
               </ser:GetResponPLPTujuan>
            </soapenv:Body>
         </soapenv:Envelope>';
    $cek = cek_go_live($UserName);
    if ($cek == "T") {
		$cek = checkUser($Username,$Password);
		if (!$cek['return']) {
			return $cek['message'];
		}
        $return = "Username Anda Berstatus Non Live Bea Cukai. Data tidak diteruskan ke Bea Cukai.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }
    if ($Send['response'] != '') {
        $arr1 = 'GetResponPLPTujuanResponse';
        $arr2 = 'GetResponPLPTujuanResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = 'Failed to get response from BC';
    }
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function UploadBatalPLP($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'UploadBatalPLP', $fStream);

    $SOAPAction = 'http://services.beacukai.go.id/UploadBatalPLP';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <UploadBatalPLP xmlns="http://services.beacukai.go.id/">
                  <fStream>' . htmlspecialchars($fStream) . '</fStream>
                  <Username>' . $Username . '</Username>
                  <Password>' . $Password . '</Password>
                </UploadBatalPLP>
              </soap:Body>
            </soap:Envelope>';
    $cek = cek_go_live($Username);
    if ($cek == "T") {
		$cek = checkUser($Username,$Password);
		if (!$cek['return']) {
			return $cek['message'];
		}
        $return = "Proses Berhasil Tersimpan di Portal CFS, Data tidak diteruskan ke BC.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }

    if ($Send['response'] != '') {
        $arr1 = 'UploadBatalPLPResponse';
        $arr2 = 'UploadBatalPLPResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        /* $return = '<?xml version="1.0" encoding="UTF-8"?>
          <UploadBatalPLP>
          <status>failed</status>
          </UploadBatalPLP>'; */
        $return = 'Failed to get response from BC';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetResponBatalPLP($UserName, $Password, $Kd_asp) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($UserName, $Password, $CONF['url.wsdl'], 'GetResponBatalPLP', $Kd_asp);

    $SOAPAction = 'http://services.beacukai.go.id/GetResponBatalPLP';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetResponBatalPLP xmlns="http://services.beacukai.go.id/">
                  <Username>' . $UserName . '</Username>
                  <Password>' . $Password . '</Password>
                  <Kd_asp>' . $Kd_asp . '</Kd_asp>
                </GetResponBatalPLP>
              </soap:Body>
            </soap:Envelope>';
    $cek = cek_go_live($UserName);
    if ($cek == "T") {
        $return = '<?xml version="1.0" encoding="UTF-8" ?> <DOCUMENT> <RESPON_BATAL>  <HEADER><DEMO>DEMO DATA</DEMO>   <KD_KANTOR></KD_KANTOR>   <KD_TPS></KD_TPS>   <REF_NUMBER></REF_NUMBER>   <NO_BATAL_PLP></NO_BATAL_PLP >   <TGL_ BATAL_PLP></TGL_ BATAL_PLP >  </HEADER>  <DETIL>  <CONT>   <NO_CONT></NO_CONT>     <UK_CONT></UK_CONT>   <FL_SETUJU></FL_SETUJU>  </CONT>  </DETIL> </ RESPON_BATAL > </DOCUMENT>';
		$cek = checkUser($Username,$Password);
		if (!$cek['return']) {
			return $cek['message'];
		}
        $return = "Username Anda Berstatus Non Live Bea Cukai. Data tidak diteruskan ke Bea Cukai.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }
    if ($Send['response'] != '') {
        $arr1 = 'GetResponBatalPLPResponse';
        $arr2 = 'GetResponBatalPLPResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        /* $return = '<?xml version="1.0" encoding="UTF-8"?>
          <GetResponBatalPLP>
          <status>failed</status>
          </GetResponBatalPLP>'; */
        $return = 'Failed to get response from BC';
    }
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function ReceiveResponBatalPLP($fStream, $Username, $Password, $Kd_asp) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ReceiveResponBatalPLP', $Kd_asp);
	$cek = checkUser($Username,$Password);
	if (!$cek['return']) {
		return $cek['message'];
	}
	$return = "Proses Berhasil Tersimpan di CFS Portal.";
    updateLogServices($IDLogServices, $fStream);
    $conn->disconnect();
    return $return;
}

function GetResponBatalPLPTujuan($UserName, $Password, $Kd_asp) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($UserName, $Password, $CONF['url.wsdl'], 'GetResponBatalPLPTujuan', $Kd_asp);

    $SOAPAction = 'http://services.beacukai.go.id/GetResponBatalPLPTujuan';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetResponBatalPLPTujuan xmlns="http://services.beacukai.go.id/">
                  <Username>' . $UserName . '</Username>
                  <Password>' . $Password . '</Password>
                  <Kd_asp>' . $Kd_asp . '</Kd_asp>
                </GetResponBatalPLPTujuan>
              </soap:Body>
            </soap:Envelope>';
    $cek = cek_go_live($UserName);
    if ($cek == "T" && ($UserName!='PLDC' && $UserName!='MTI')) {
        $return = '<?xml version="1.0" encoding="UTF-8" ?> <DOCUMENT> <RESPON_BATAL> <HEADER><DEMO>DEMO DATA</DEMO>  <KD_KANTOR></KD_KANTOR>  <KD_TPS></KD_TPS>  <KD_TPS_ASAL></KD_TPS_ASAL>  <NO_PLP></NO_PLP>  <TGL_PLP></TGL_PLP>  <NO_BATAL_PLP></NO_BATAL_PLP >  <TGL_ BATAL_PLP></TGL_ BATAL_PLP > </HEADER> <DETIL>  <CONT>  <NO_CONT></NO_CONT>    <UK_CONT></UK_CONT>  </CONT>  </DETIL> </ RESPON_BATAL> </DOCUMENT>';
		$cek = checkUser($Username,$Password);
		if (!$cek['return']) {
			return $cek['message'];
		}
        $return = "Username Anda Berstatus Non Live Bea Cukai. Data tidak diteruskan ke Bea Cukai.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }
    if ($Send['response'] != '') {
        $arr1 = 'GetResponBatalPLPTujuanResponse';
        $arr2 = 'GetResponBatalPLPTujuanResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        /* $return = '<?xml version="1.0" encoding="UTF-8"?>
          <GetResponBatalPLPTujuan>
          <status>failed</status>
          </GetResponBatalPLPTujuan>'; */
        $return = 'Failed to get response from BC';
    }
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function ReceiveResponBatalPLPTujuan($Username, $Password, $Kd_asp, $fStream) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ReceiveResponBatalPLPTujuan', $Kd_asp);
	$cek = checkUser($Username,$Password);
	if (!$cek['return']) {
		updateLogServices($IDLogServices, $fStream);
		updateLogServicesToFailed($IDLogServices, $cek['message']);
        return $cek['message'];
    }

	$STR_DATA = $fStream;//str_replace('&', '&amp;', $fStream);

	libxml_use_internal_errors(true);

	$doc = simplexml_load_string($STR_DATA); // array object
	$xml = explode("\n", $STR_DATA);
	$return=$STR_DATA;//"";

	if (!$doc) {
		$errors = libxml_get_errors();
		foreach ($errors as $error) {
			$return .= display_xml_error($error, $xml);
		}

		libxml_clear_errors();
	}else{
		$return = "Proses Berhasil Tersimpan di CFS Portal.";
    }
	
	updateLogServices($IDLogServices, $fStream);
    $conn->disconnect();
    return $return;
}

function CoCoTangki($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'CoCoTangki', $fStream);

    $SOAPAction = 'http://services.beacukai.go.id/CoCoTangki';
    $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.beacukai.go.id/">
            <soapenv:Header/>
            <soapenv:Body>
               <ser:CoCoTangki>
                  <!--Optional:-->
                  <ser:fStream>' . htmlspecialchars($fStream) . '</ser:fStream>
                  <!--Optional:-->
                  <ser:Username>' . $Username . '</ser:Username>
                  <!--Optional:-->
                  <ser:Password>' . $Password . '</ser:Password>
               </ser:CoCoTangki>
            </soapenv:Body>
         </soapenv:Envelope>';
    $cek = cek_go_live($Username);
    if ($cek == "T") {
        $return = "Proses Berhasil Tersimpan di Portal CFS, Data tidak diteruskan ke BC.";
		$cek = checkUser($Username,$Password);
		if (!$cek['return']) {
			return $cek['message'];
		}
        $return = "Username Anda Berstatus Non Live Bea Cukai. Data tidak diteruskan ke Bea Cukai.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }

    if ($Send['response'] != '') {
        $arr1 = 'CoCoTangkiResponse';
        $arr2 = 'CoCoTangkiResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = 'Failed to get response from BC';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function CoarriCodeco_Container($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'CoarriCodeco_Container', $fStream);

    $SOAPAction = 'http://services.beacukai.go.id/CoarriCodeco_Container';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                <soap:Body>
                    <CoarriCodeco_Container xmlns="http://services.beacukai.go.id/">
                        <fStream>' . htmlspecialchars($fStream) . '</fStream>
                        <Username>' . $Username . '</Username>
                        <Password>' . $Password . '</Password>
                    </CoarriCodeco_Container>
                </soap:Body>
            </soap:Envelope>';
	$cek = checkUser($Username,$Password);
	if (!$cek['return']) {
		updateLogServices($IDLogServices, $fStream);
		updateLogServicesToFailed($IDLogServices, $cek['message']);
		return $cek['message'];
	}
    $cek = cek_go_live($Username);
    if ($cek == "T") {
		$STR_DATA = $fStream;//str_replace('&', '&amp;', $fStream);

		libxml_use_internal_errors(true);

		$doc = simplexml_load_string($STR_DATA); // array object
		$xml = explode("\n", $STR_DATA);
		$return=$STR_DATA;//"";

		if (!$doc) {
			$errors = libxml_get_errors();
			foreach ($errors as $error) {
				$return .= display_xml_error($error, $xml);
			}

			libxml_clear_errors();
		}else{
			$return = "Proses Berhasil Tersimpan di Portal CFS, Data tidak diteruskan ke BC.";
		}
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }

    if ($Send['response'] != '') {
        $arr1 = 'CoarriCodeco_ContainerResponse';
        $arr2 = 'CoarriCodeco_ContainerResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        /* $return = '<?xml version="1.0" encoding="UTF-8"?>
          <CoarriCodeco_Container>
          <status>failed</status>
          </CoarriCodeco_Container>'; */
        $return = 'Failed to get response from BC';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function CoarriCodeco_Kemasan($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'CoarriCodeco_Kemasan', $fStream);

    $SOAPAction = 'http://services.beacukai.go.id/CoarriCodeco_Kemasan';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                <soap:Body>
                    <CoarriCodeco_Kemasan xmlns="http://services.beacukai.go.id/">
                        <fStream>' . htmlspecialchars($fStream) . '</fStream>
                        <Username>' . $Username . '</Username>
                        <Password>' . $Password . '</Password>
                    </CoarriCodeco_Kemasan>
                </soap:Body>
            </soap:Envelope>';

	$cek = checkUser($Username,$Password);
	if (!$cek['return']) {
		updateLogServices($IDLogServices, $fStream);
		updateLogServicesToFailed($IDLogServices, $cek['message']);
		return $cek['message'];
	}
    $cek = cek_go_live($Username);
    if ($cek == "T") {
		$STR_DATA = $fStream;//str_replace('&', '&amp;', $fStream);

		libxml_use_internal_errors(true);

		$doc = simplexml_load_string($STR_DATA); // array object
		$xml = explode("\n", $STR_DATA);
		$return=$STR_DATA;//"";

		if (!$doc) {
			$errors = libxml_get_errors();
			foreach ($errors as $error) {
				$return .= display_xml_error($error, $xml);
			}

			libxml_clear_errors();
		}else{
			$return = "Proses Berhasil Tersimpan di Portal CFS, Data tidak diteruskan ke BC.";
		}
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }

    if ($Send['response'] != '') {
        $arr1 = 'CoarriCodeco_KemasanResponse';
        $arr2 = 'CoarriCodeco_KemasanResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        /* $return = '<?xml version="1.0" encoding="UTF-8"?>
          <CoarriCodeco_Kemasan>
          <status>failed</status>
          </CoarriCodeco_Kemasan>'; */
        $return = 'Failed to get response from BC';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetSubTotal_Billing($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'GetSubTotal_Billing', $fStream);

    $SOAPAction = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                <soap:Body>
                    <GetSubTotal_Billing xmlns="http://ipccfscenter.com/TPSServices/">
                        <fStream>' . htmlspecialchars($fStream) . '</fStream>
                        <Username>' . $Username . '</Username>
                        <Password>' . $Password . '</Password>
                    </GetSubTotal_Billing>
                </soap:Body>
            </soap:Envelope>';



    /* $cek = cek_go_live($Username);  
      if($cek == "T"){
      $Send = SendCurl($xml, $WSDLSOAP, $SOAPAction);
      }else{

      $return = "Proses Berhasil Tersimpan di Portal CFS";
      updateLogServices($IDLogServices, $return);
      $conn->disconnect();
      return $return;
      die();
      }

      if ($Send['response'] != '') {
      $arr1 = 'GetSubTotal_BillingResponse';
      $arr2 = 'GetSubTotal_BillingResult';
      $response = xml2ary($Send['response']);
      $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
      } else {
      $return = '<?xml version="1.0" encoding="UTF-8"?>
      <GetSubTotal_Billing>
      <status>failed</status>
      </GetSubTotal_Billing>';
      } */

	$cek = checkUser($Username,$Password);
	if (!$cek['return']) {
		return $cek['message'];
	}
	$return = "Username Anda Berstatus Non Live Bea Cukai. Data tidak diteruskan ke Bea Cukai.";
    $return = "Proses Berhasil Tersimpan di Portal CFS";
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetImpor_Sppb($Username, $Password, $No_Sppb, $Tgl_Sppb, $NPWP_Imp) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'GetImpor_Sppb', $No_Sppb . "-" . $Tgl_Sppb . "-" . $NPWP_Imp);

    $SOAPAction = 'http://services.beacukai.go.id/GetImpor_Sppb';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetImpor_Sppb xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $Username . '</UserName>
                  <Password>' . $Password . '</Password>
                  <No_Sppb>' . $No_Sppb . '</No_Sppb>
                  <Tgl_Sppb>' . $Tgl_Sppb . '</Tgl_Sppb>
                  <NPWP_Imp>' . $NPWP_Imp . '</NPWP_Imp>
                </GetImpor_Sppb>
              </soap:Body>
            </soap:Envelope>';

	$cek = cek_go_live($Username);
    if ($cek == "T") {
		$cek = checkUser($Username,$Password);
		if (!$cek['return']) {
			return $cek['message'];
		}
        $return = "Username Anda Berstatus Non Live Bea Cukai. Data tidak diteruskan ke Bea Cukai.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }

    if ($Send['response'] != '') {
        $arr1 = 'GetImpor_SppbResponse';
        $arr2 = 'GetImpor_SppbResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        /* $return = '<?xml version="1.0" encoding="UTF-8"?>
          <GetImpor_Sppb>
          <status>failed</status>
          </GetImpor_Sppb>'; */
        $return = 'Failed to get response from BC';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function ReceiveImpor_Sppb($Username, $Password, $No_Sppb, $Tgl_Sppb, $NPWP_Imp, $fStream) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ReceiveImpor_Sppb', $No_Sppb . "-" . $Tgl_Sppb . "-" . $NPWP_Imp);
	$cek = checkUser($Username,$Password);
	if (!$cek['return']) {
		updateLogServices($IDLogServices, $fStream);
		updateLogServicesToFailed($IDLogServices, $cek['message']);
        return $cek['message'];
    }

	$STR_DATA = $fStream;//str_replace('&', '&amp;', $fStream);

	libxml_use_internal_errors(true);

	$doc = simplexml_load_string($STR_DATA); // array object
	$xml = explode("\n", $STR_DATA);
	$return=$STR_DATA;//"";

	if (!$doc) {
		$errors = libxml_get_errors();
		foreach ($errors as $error) {
			$return .= display_xml_error($error, $xml);
		}

		libxml_clear_errors();
	}else{
		$return = "Proses Berhasil Tersimpan di CFS Portal.";
    }
    updateLogServices($IDLogServices, $fStream);
    $conn->disconnect();
    return $return;
}

function GetImporPermit($Username, $Password, $kd_gudang) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'GetImporPermit', $kd_gudang);

    $SOAPAction = 'http://services.beacukai.go.id/GetImporPermit';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetImporPermit xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $Username . '</UserName>
                  <Password>' . $Password . '</Password>
                  <Kd_Gudang>' . $kd_gudang . '</Kd_Gudang>                  
                </GetImporPermit>
              </soap:Body>
            </soap:Envelope>';
    $cek = cek_go_live($Username);
    if ($cek == "T") {
		$cek = checkUser($Username,$Password);
		if (!$cek['return']) {
			return $cek['message'];
		}
        $return = "Username Anda Berstatus Non Live Bea Cukai. Data tidak diteruskan ke Bea Cukai.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }
    if ($Send['response'] != '') {
        $arr1 = 'GetImporPermitResponse';
        $arr2 = 'GetImporPermitResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        /* $return = '<?xml version="1.0" encoding="UTF-8"?>
          <GetImporPermit>
          <status>failed</status>
          </GetImporPermit>'; */
        $return = 'Failed to get response from BC';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function ReceiveImporPermit($Username, $Password, $kd_gudang, $fStream) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ReceiveImporPermit', $kd_gudang);
	$cek = checkUser($Username,$Password);
	if (!$cek['return']) {
		updateLogServices($IDLogServices, $fStream);
		updateLogServicesToFailed($IDLogServices, $cek['message']);
        return $cek['message'];
    }

	$STR_DATA = $fStream;//str_replace('&', '&amp;', $fStream);

	libxml_use_internal_errors(true);

	$doc = simplexml_load_string($STR_DATA); // array object
	$xml = explode("\n", $STR_DATA);
	$return=$STR_DATA;//"";

	if (!$doc) {
		$errors = libxml_get_errors();
		foreach ($errors as $error) {
			$return .= display_xml_error($error, $xml);
		}

		libxml_clear_errors();
	}else{
		$return = "Proses Berhasil Tersimpan di CFS Portal.";
    }
    updateLogServices($IDLogServices, $fStream);
    $conn->disconnect();
    return $return;
}

function GetImporPermit_Manual($Username, $Password, $kd_gudang) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'GetImporPermit_Manual', $kd_gudang);

	$SQLCEK = "SELECT KD_GUDANG FROM t_organisasi WHERE USERNAME_TPSONLINE_BC = '" . $Username . "' AND PASSWORD_TPSONLINE_BC = '" . $Password . "'";
	$QueryCek = $conn->query($SQLCEK);
    if ($QueryCek->size() > 0) {
        $QueryCek->next();
        $KD_GUDANG = $QueryCek->get("KD_GUDANG");
		if($kd_gudang==$KD_GUDANG) $KD_CEK=true;
    } else {
        $KD_GUDANG = "";
    }

	if ($KD_GUDANG==""||!$KD_CEK) {
		$message .= 'Maaf coba cek kembali Username dan Password Anda ! ';
	}else{
		$SQL = "SELECT * FROM t_permit_hdr WHERE KD_GUDANG = '" . $KD_GUDANG . "' AND ID_LOG='MANUAL' AND KD_STATUS='100' LIMIT 3";
		$Query = $conn->query($SQL);
		if ($Query->size() > 0) { 
			$message = '<?xml version="1.0" encoding="UTF-8"?>';
			$message .= '<DOCUMENT>';
			while ($Query->next()) {
				$ID = $Query->get("ID");
	            $CAR = $Query->get("CAR");
				
				$message .= '<SPPB>';
				$message .= '<HEADER>';
				$message .= '<CAR>'.$CAR.'</CAR>';
				$message .= '<KD_DOK_BC>'.$Query->get("KD_DOK_INOUT").'</KD_DOK_BC>';
				$message .= '<KD_KPBC>'.$Query->get("KD_KANTOR").'</KD_KPBC>';
				$message .= '<NO_SPPB>'.$Query->get("NO_DOK_INOUT").'</NO_SPPB>';
				$message .= '<TGL_SPPB>'.$Query->get("TGL_DOK_INOUT").'</TGL_SPPB>';
				$message .= '<NO_PIB>'.$Query->get("NO_DAFTAR_PABEAN").'</NO_PIB>';
				$message .= '<TGL_PIB>'.$Query->get("TGL_DAFTAR_PABEAN").'</TGL_PIB>';
				$message .= '<NPWP_IMP>'.$Query->get("ID_CONSIGNEE").'</NPWP_IMP>';
				$message .= '<NAMA_IMP>'.htmlspecialchars($Query->get("CONSIGNEE"), ENT_QUOTES).'</NAMA_IMP>';
				$message .= '<ALAMAT_IMP>'.htmlspecialchars($Query->get("ALAMAT_CONSIGNEE"), ENT_QUOTES).'</ALAMAT_IMP>';
				$message .= '<NPWP_PPJK>'.$Query->get("NPWP_PPJK").'</NPWP_PPJK>';
				$message .= '<NAMA_PPJK>'.htmlspecialchars($Query->get("NAMA_PPJK"), ENT_QUOTES).'</NAMA_PPJK>';
				$message .= '<ALAMAT_PPJK>'.htmlspecialchars($Query->get("ALAMAT_PPJK"), ENT_QUOTES).'</ALAMAT_PPJK>';
				$message .= '<NM_ANGKUT>'.$Query->get("NM_ANGKUT").'</NM_ANGKUT>';
				$message .= '<NO_VOY_FLIGHT>'.$Query->get("NO_VOY_FLIGHT").'</NO_VOY_FLIGHT>';
				$message .= '<BRUTO>'.$Query->get("BRUTO").'</BRUTO>';
				$message .= '<NETTO>'.$Query->get("NETTO").'</NETTO>';
				$message .= '<GUDANG>'.$Query->get("KD_GUDANG").'</GUDANG>';
				$message .= '<STATUS_JALUR>'.$Query->get("STATUS_JALUR").'</STATUS_JALUR>';
				$message .= '<JML_CONT>'.$Query->get("JML_CONT").'</JML_CONT>';
				$message .= '<NO_BC11>'.$Query->get("NO_BC11").'</NO_BC11>';
				$message .= '<TGL_BC11>'.$Query->get("TGL_BC11").'</TGL_BC11>';
				$message .= '<NO_POS_BC11>'.$Query->get("NO_POS_BC11").'</NO_POS_BC11>';
				$message .= '<NO_BL_AWB>'.htmlspecialchars($Query->get("NO_BL_AWB"), ENT_QUOTES).'</NO_BL_AWB>';
				$message .= '<TG_BL_AWB>'.$Query->get("TGL_BL_AWB").'</TG_BL_AWB>';
				$message .= '<NO_MASTER_BL_AWB>'.htmlspecialchars($Query->get("NO_MASTER_BL_AWB"), ENT_QUOTES).'</NO_MASTER_BL_AWB>';
				$message .= '<TG_MASTER_BL_AWB>'.$Query->get("TGL_MASTER_BL_AWB").'</TG_MASTER_BL_AWB>';
				$message .= '<KD_KANTOR_PENGAWAS>'.$Query->get("KD_KANTOR_PENGAWAS").'</KD_KANTOR_PENGAWAS>';
				$message .= '<KD_KANTOR_BONGKAR>'.$Query->get("KD_KANTOR_BONGKAR").'</KD_KANTOR_BONGKAR>';
				$message .= '</HEADER>';
				$message .= '<DETAIL>';
				$SQLcont = "SELECT * FROM t_permit_cont WHERE ID = '" . $ID . "'";
				$Querycont = $conn->query($SQLcont);
				if ($Querycont->size() > 0) { 
					while ($Querycont->next()) {
						$message .= '<CONT>';
						$message .= '<CAR>'.$CAR.'</CAR>';
						$message .= '<NO_CONT>'.htmlspecialchars($Querycont->get("NO_CONT"), ENT_QUOTES).'</NO_CONT>';
						$message .= '<SIZE>'.$Querycont->get("KD_CONT_UKURAN").'</SIZE>';
						$message .= '<JNS_MUAT>'.$Querycont->get("KD_CONT_JENIS").'</JNS_MUAT>';
						$message .= '</CONT>';
					}
				}
				$SQLkms = "SELECT * FROM t_permit_kms WHERE ID = '" . $ID . "'";
				$Querykms = $conn->query($SQLkms);
				if ($Querykms->size() > 0) { 
					while ($Querykms->next()) {
						$message .= '<KMS>';
						$message .= '<CAR>'.$CAR.'</CAR>';
						$message .= '<JNS_KMS>'.$Querykms->get("JNS_KMS").'</JNS_KMS>';
						$message .= '<MERK_KMS>'.htmlspecialchars($Querykms->get("MERK_KMS"), ENT_QUOTES).'</MERK_KMS>';
						$message .= '<JML_KMS>'.$Querykms->get("JML_KMS").'</JML_KMS>';
						$message .= '</KMS>';
					}
				}
				$message .= '</DETAIL>';
				$message .= '</SPPB>';
			}
			$message .= '</DOCUMENT>';
		}else{
			$message .= 'Data tidak ditemukan';
		}
	}
    $return = $message;

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetImporPermit_FASP($Username, $Password, $Kd_ASP) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'GetImporPermit_FASP', $Kd_ASP);

    $SOAPAction = 'http://services.beacukai.go.id/GetImporPermit_FASP';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetImporPermit_FASP xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $Username . '</UserName>
                  <Password>' . $Password . '</Password>
                  <Kd_ASP>' . $Kd_ASP . '</Kd_ASP>                  
                </GetImporPermit_FASP>
              </soap:Body>
            </soap:Envelope>';
    $cek = cek_go_live($Username);
    if ($cek == "T") {
		$cek = checkUser($Username,$Password);
		if (!$cek['return']) {
			return $cek['message'];
		}
        $return = "Username Anda Berstatus Non Live Bea Cukai. Data tidak diteruskan ke Bea Cukai.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }
    if ($Send['response'] != '') {
        $arr1 = 'GetImporPermit_FASPResponse';
        $arr2 = 'GetImporPermit_FASPResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        /* $return = '<?xml version="1.0" encoding="UTF-8"?>
          <GetImporPermit_FASP>
          <status>failed</status>
          </GetImporPermit_FASP>'; */
        $return = 'Failed to get response from BC';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function ReceiveImporPermit_FASP($Username, $Password, $Kd_ASP, $fStream) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ReceiveImporPermit_FASP', $Kd_ASP);
	$cek = checkUser($Username,$Password);
	if (!$cek['return']) {
		updateLogServices($IDLogServices, $fStream);
		updateLogServicesToFailed($IDLogServices, $cek['message']);
        return $cek['message'];
    }

	$STR_DATA = $fStream;//str_replace('&', '&amp;', $fStream);

	libxml_use_internal_errors(true);

	$doc = simplexml_load_string($STR_DATA); // array object
	$xml = explode("\n", $STR_DATA);
	$return=$STR_DATA;//"";

	if (!$doc) {
		$errors = libxml_get_errors();
		foreach ($errors as $error) {
			$return .= display_xml_error($error, $xml);
		}

		libxml_clear_errors();
	}else{
		$return = "Proses Berhasil Tersimpan di CFS Portal.";
    }
    updateLogServices($IDLogServices, $fStream);
    $conn->disconnect();
    return $return;
}

function GetSppb_Bc23($Username, $Password, $No_Sppb, $Tgl_Sppb, $NPWP_Imp) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'GetSppb_Bc23', $No_Sppb . "-" . $Tgl_Sppb . "-" . $NPWP_Imp);

    $SOAPAction = 'http://services.beacukai.go.id/GetSppb_Bc23';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetSppb_Bc23 xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $Username . '</UserName>
                  <Password>' . $Password . '</Password>
                  <No_Sppb>' . $No_Sppb . '</No_Sppb>
                  <Tgl_Sppb>' . $Tgl_Sppb . '</Tgl_Sppb>
                  <NPWP_Imp>' . $NPWP_Imp . '</NPWP_Imp>
                </GetSppb_Bc23>
              </soap:Body>
            </soap:Envelope>';
    $cek = cek_go_live($Username);
    if ($cek == "T") {
		$cek = checkUser($Username,$Password);
		if (!$cek['return']) {
			return $cek['message'];
		}
        $return = "Username Anda Berstatus Non Live Bea Cukai. Data tidak diteruskan ke Bea Cukai.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }
    if ($Send['response'] != '') {
        $arr1 = 'GetSppb_Bc23Response';
        $arr2 = 'GetSppb_Bc23Result';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        /* $return = '<?xml version="1.0" encoding="UTF-8"?>
          <GetSppb_Bc23>
          <status>failed</status>
          </GetSppb_Bc23>'; */
        $return = 'Failed to get response from BC';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function ReceiveSppb_Bc23($Username, $Password, $No_Sppb, $Tgl_Sppb, $NPWP_Imp, $fStream) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ReceiveSppb_Bc23', $No_Sppb . "-" . $Tgl_Sppb . "-" . $NPWP_Imp);
	$cek = checkUser($Username,$Password);
	if (!$cek['return']) {
		updateLogServices($IDLogServices, $fStream);
		updateLogServicesToFailed($IDLogServices, $cek['message']);
        return $cek['message'];
    }

	$STR_DATA = $fStream;//str_replace('&', '&amp;', $fStream);

	libxml_use_internal_errors(true);

	$doc = simplexml_load_string($STR_DATA); // array object
	$xml = explode("\n", $STR_DATA);
	$return=$STR_DATA;//"";

	if (!$doc) {
		$errors = libxml_get_errors();
		foreach ($errors as $error) {
			$return .= display_xml_error($error, $xml);
		}

		libxml_clear_errors();
	}else{
		$return = "Proses Berhasil Tersimpan di CFS Portal.";
    }
    updateLogServices($IDLogServices, $fStream);
    $conn->disconnect();
    return $return;
}

function GetBC23Permit($Username, $Password, $kd_gudang) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'GetBC23Permit', $kd_gudang);

    $SOAPAction = 'http://services.beacukai.go.id/GetBC23Permit';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetBC23Permit xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $Username . '</UserName>
                  <Password>' . $Password . '</Password>
                  <Kd_Gudang>' . $kd_gudang . '</Kd_Gudang>                  
                </GetBC23Permit>
              </soap:Body>
            </soap:Envelope>';
    $cek = cek_go_live($Username);
    if ($cek == "T") {
		$cek = checkUser($Username,$Password);
		if (!$cek['return']) {
			return $cek['message'];
		}
        $return = "Username Anda Berstatus Non Live Bea Cukai. Data tidak diteruskan ke Bea Cukai.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }
    if ($Send['response'] != '') {
        $arr1 = 'GetBC23PermitResponse';
        $arr2 = 'GetBC23PermitResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        /* $return = '<?xml version="1.0" encoding="UTF-8"?>
          <GetBC23Permit>
          <status>failed</status>
          </GetBC23Permit>'; */
        $return = 'Failed to get response from BC';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function ReceiveBC23Permit($Username, $Password, $kd_gudang, $fStream) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ReceiveBC23Permit', $kd_gudang);
	$cek = checkUser($Username,$Password);
	if (!$cek['return']) {
		updateLogServices($IDLogServices, $fStream);
		updateLogServicesToFailed($IDLogServices, $cek['message']);
        return $cek['message'];
    }

	$STR_DATA = $fStream;//str_replace('&', '&amp;', $fStream);

	libxml_use_internal_errors(true);

	$doc = simplexml_load_string($STR_DATA); // array object
	$xml = explode("\n", $STR_DATA);
	$return=$STR_DATA;//"";

	if (!$doc) {
		$errors = libxml_get_errors();
		foreach ($errors as $error) {
			$return .= display_xml_error($error, $xml);
		}

		libxml_clear_errors();
	}else{
		$return = "Proses Berhasil Tersimpan di CFS Portal.";
    }
    updateLogServices($IDLogServices, $fStream);
    $conn->disconnect();
    return $return;
}

function GetBC23Permit_FASP($Username, $Password, $Kd_ASP) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'GetBC23Permit_FASP', $Kd_ASP);

    $SOAPAction = 'http://services.beacukai.go.id/GetBC23Permit_FASP';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetBC23Permit_FASP xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $Username . '</UserName>
                  <Password>' . $Password . '</Password>
                  <Kd_ASP>' . $Kd_ASP . '</Kd_ASP>                  
                </GetBC23Permit_FASP>
              </soap:Body>
            </soap:Envelope>';
    $cek = cek_go_live($Username);
    if ($cek == "T") {
		$cek = checkUser($Username,$Password);
		if (!$cek['return']) {
			return $cek['message'];
		}
        $return = "Username Anda Berstatus Non Live Bea Cukai. Data tidak diteruskan ke Bea Cukai.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }
    if ($Send['response'] != '') {
        $arr1 = 'GetBC23Permit_FASPResponse';
        $arr2 = 'GetBC23Permit_FASPResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        /* $return = '<?xml version="1.0" encoding="UTF-8"?>
          <GetBC23Permit_FASP>
          <status>failed</status>
          </GetBC23Permit_FASP>'; */
        $return = 'Failed to get response from BC';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function ReceiveBC23Permit_FASP($Username, $Password, $Kd_ASP, $fStream) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ReceiveBC23Permit_FASP', $Kd_ASP);
	$cek = checkUser($Username,$Password);
	if (!$cek['return']) {
		updateLogServices($IDLogServices, $fStream);
		updateLogServicesToFailed($IDLogServices, $cek['message']);
        return $cek['message'];
    }

	$STR_DATA = $fStream;//str_replace('&', '&amp;', $fStream);

	libxml_use_internal_errors(true);

	$doc = simplexml_load_string($STR_DATA); // array object
	$xml = explode("\n", $STR_DATA);
	$return=$STR_DATA;//"";

	if (!$doc) {
		$errors = libxml_get_errors();
		foreach ($errors as $error) {
			$return .= display_xml_error($error, $xml);
		}

		libxml_clear_errors();
	}else{
		$return = "Proses Berhasil Tersimpan di CFS Portal.";
    }
    updateLogServices($IDLogServices, $fStream);
    $conn->disconnect();
    return $return;
}

function GetSPJM($Username, $Password, $Kd_Tps) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'GetSPJM', $Kd_Tps);

    $SOAPAction = 'http://services.beacukai.go.id/GetSPJM';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetSPJM xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $Username . '</UserName>
                  <Password>' . $Password . '</Password>
                  <Kd_Tps>' . $Kd_Tps . '</Kd_Tps>                  
                </GetSPJM>
              </soap:Body>
            </soap:Envelope>';
    $cek = cek_go_live($Username);
    if ($cek == "T") {
		$cek = checkUser($Username,$Password);
		if (!$cek['return']) {
			return $cek['message'];
		}
        $return = "Username Anda Berstatus Non Live Bea Cukai. Data tidak diteruskan ke Bea Cukai.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }
    if ($Send['response'] != '') {
        $arr1 = 'GetSPJMResponse';
        $arr2 = 'GetSPJMResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        /* $return = '<?xml version="1.0" encoding="UTF-8"?>
          <GetSPJM>
          <status>failed</status>
          </GetSPJM>'; */
        $return = 'Failed to get response from BC';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function ReceiveSPJM($Username, $Password, $Kd_Tps, $fStream) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ReceiveSPJM', $Kd_Tps);
	$cek = checkUser($Username,$Password);
	if (!$cek['return']) {
		updateLogServices($IDLogServices, $fStream);
		updateLogServicesToFailed($IDLogServices, $cek['message']);
        return $cek['message'];
    }

	$STR_DATA = $fStream;//str_replace('&', '&amp;', $fStream);

	libxml_use_internal_errors(true);

	$doc = simplexml_load_string($STR_DATA); // array object
	$xml = explode("\n", $STR_DATA);
	$return=$STR_DATA;//"";

	if (!$doc) {
		$errors = libxml_get_errors();
		foreach ($errors as $error) {
			$return .= display_xml_error($error, $xml);
		}

		libxml_clear_errors();
	}else{
		$return = "Proses Berhasil Tersimpan di CFS Portal.";
    }
    updateLogServices($IDLogServices, $fStream);
    $conn->disconnect();
    return $return;
}

function GetSPJM_onDemand($Username, $Password, $noPib, $tglPib) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'GetSPJM_onDemand', $noPib . "-" . $tglPib);

    $SOAPAction = 'http://services.beacukai.go.id/GetSPJM_onDemand';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetSPJM_onDemand xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $Username . '</UserName>
                  <Password>' . $Password . '</Password>
                  <noPib>' . $noPib . '</noPib>
                  <tglPib>' . $tglPib . '</tglPib>
                </GetSPJM_onDemand>
              </soap:Body>
            </soap:Envelope>';
    $cek = cek_go_live($Username);
    if ($cek == "T") {
		$cek = checkUser($Username,$Password);
		if (!$cek['return']) {
			return $cek['message'];
		}
        $return = "Username Anda Berstatus Non Live Bea Cukai. Data tidak diteruskan ke Bea Cukai.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }
    if ($Send['response'] != '') {
        $arr1 = 'GetSPJM_onDemandResponse';
        $arr2 = 'GetSPJM_onDemandResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        /* $return = '<?xml version="1.0" encoding="UTF-8"?>
          <GetSPJM_onDemand>
          <status>failed</status>
          </GetSPJM_onDemand>'; */
        $return = 'Failed to get response from BC';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function ReceiveSPJM_onDemand($Username, $Password, $noPib, $tglPib, $fStream) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ReceiveSPJM_onDemand', $noPib . "-" . $tglPib);
	$cek = checkUser($Username,$Password);
	if (!$cek['return']) {
		updateLogServices($IDLogServices, $fStream);
		updateLogServicesToFailed($IDLogServices, $cek['message']);
        return $cek['message'];
    }

	$STR_DATA = $fStream;//str_replace('&', '&amp;', $fStream);

	libxml_use_internal_errors(true);

	$doc = simplexml_load_string($STR_DATA); // array object
	$xml = explode("\n", $STR_DATA);
	$return=$STR_DATA;//"";

	if (!$doc) {
		$errors = libxml_get_errors();
		foreach ($errors as $error) {
			$return .= display_xml_error($error, $xml);
		}

		libxml_clear_errors();
	}else{
		$return = "Proses Berhasil Tersimpan di CFS Portal.";
    }
    updateLogServices($IDLogServices, $fStream);
    $conn->disconnect();
    return $return;
}

function LoadBilling($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://103.29.187.215/cfs-center/TPSServices/sever_plp.php?wsdl';
    // print_r("ok");die();
    // print_r($Password);die();
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'LoadBilling', $fStream);

    if (strpos($fStream, '?xml') !== FALSE) {
        
    } else {
        $message = '<?xml version="1.0" encoding="UTF-8"?>';
        $message .= '<DOCUMENT>';
        $message .= '<LOADBILLING>';
        $message .= '<RESPON>Format fStream SALAH!!!</RESPON>';
        $message .= '</LOADBILLING>';
        $message .= '</DOCUMENT>';
    }
    $xml1 = str_replace('&', '', $fStream);
    // print_r($xml);die();
    $SQLlogin = "SELECT ID FROM t_organisasi WHERE USERNAME_TPSONLINE_BC = '" . $Username . "'";
    // echo $SQLlogin;die();
    // print_r($SQLlogin);die();
    $Query = $conn->query($SQLlogin);
    if ($Query->size() > 0) {
        $Query->next();
        $KD_ORG_SENDER = $Query->get("ID");
    } else {
        $KD_ORG_SENDER = "";
    }
    $STR_DATA = $fStream;


    $SQL = "INSERT INTO mailbox (SNRF, KD_APRF, KD_ORG_SENDER, KD_ORG_RECEIVER,
                        STR_DATA, KD_STATUS, TGL_STATUS)
                VALUES (NULL,'GETBILLING', '" . $KD_ORG_SENDER . "', '1',
                        '" . $STR_DATA . "','100', NOW())";
    // echo $SQL;die();
    // print_r($SQL);die();
    $Execute = $conn->execute($SQL);
    if ($Execute != '') {
        //BEGIN
        $SQL = "SELECT a.ID, a.STR_DATA FROM mailbox a WHERE a.KD_APRF = 'GETBILLING' AND a.KD_STATUS = '100' order by a.TGL_STATUS ASC limit 5";
        // echo $SQL;die();
        // print_r($SQL);die();
        $Query = $conn->query($SQL);
        if ($Query->size() > 0) {
            while ($Query->next()) {
                $ID_LOG = $Query->get("ID");
                $STR_DATA = $Query->get("STR_DATA");
                $xml = xml2ary($STR_DATA);
                // print_r($xml);die();
                if (count($xml) > 0) {
                    $xml = $xml['DOCUMENT']['_c'];
                    $loadBillingHeaderxml = $xml['HEADER']['_c'];
                    $countBilling = 0;
                    $countBilling = count($xml['DETIL']);
                    // print_r($countBilling);die();
                    if ($countBilling > 1) {
                        $message = '<?xml version="1.0" encoding="UTF-8"?>';
                        $message .= '<DOCUMENT>';
                        $RESTBL = '';
                        // $LOADBILLING = $loadBillingxml['BILLING'][$c]['_c'];
                        $countTarif = 0;
                        $countTarif = count($countBilling['TARIF']);
                        $JENIS_BILLING = trim($loadBillingHeaderxml['JENIS_BILLING']['_v']) == "" ? "NULL" : "" . strtoupper(trim($loadBillingHeaderxml['JENIS_BILLING']['_v'])) . "";
                        $NO_ORDER = trim($loadBillingHeaderxml['NO_ORDER']['_v']) == "" ? "NULL" : "" . strtoupper(trim($loadBillingHeaderxml['NO_ORDER']['_v'])) . "";
                        $checkorder = $conn->query("SELECT ID FROM t_order_hdr WHERE NO_ORDER = '" . $NO_ORDER . "'");
						if ($checkbil->size() == 0){
							$message = '<?xml version="1.0" encoding="UTF-8"?>';
							$message .= '<DOCUMENT>';
							$message .= '<LOADBILLING>';
							$message .= '<RESPON>Nomor Order Tidak Ditemukan.</RESPON>';
							$message .= '</LOADBILLING>';
							$message .= '</DOCUMENT>';
						} else {
							$checkbil = $conn->query("SELECT ID FROM t_billing_cfshdr WHERE NO_ORDER = '" . $NO_ORDER . "' AND NO_INVOICE IS NOT NULL");
							if ($checkbil->size() == 0) {
								$IDOrder = InsertBilling($loadBillingHeaderxml, $countTarif, $countBilling);
								for ($c = 0; $c < $countBilling; $c++) {
									// $LOADBILLING = $loadBillingxml['BILLING'][$c]['_c'];
									$header = $LOADBILLING['HEADER']['_c'];
									$detil = $xml['DETIL']['_c'];
									$countTarif = 0;
									$countTarif = count($detil['TARIF']);
									$NO_ORDER = trim($loadBillingHeaderxml['NO_ORDER']['_v']) == "" ? "NULL" : "" . strtoupper(trim($loadBillingHeaderxml['NO_ORDER']['_v'])) . "";
									
									$NO_CONT = trim($detil['NO_CONT']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['NO_CONT']['_v'])) . "";
									$message .= '<LOADBILLING>';
									$message .= '<HEADER>';
									$message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
									$message .= '</HEADER>';
									$message .= '<DETIL>';
									
									if ($countTarif > 1) {
										$chektarif = '';
										for ($i = 0; $i < $countTarif; $i++) {
											$TARIF_DASAR = trim($detil['TARIF'][$i]['_c']['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['TARIF_DASAR']['_v'])) . "";
											$KODE = trim($detil['TARIF'][$i]['_c']['KODE_TARIF']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['KODE_TARIF']['_v'])) . "";
											$SQLKode = "SELECT a.TARIF_DASAR FROM reff_billing_cfs a WHERE a.KODE_BILL = '" . $KODE . "'";
											$QueryKode = $conn->query($SQLKode);
											$QueryKode->next();
											$TARIF_DASAR_CFS = $QueryKode->get("TARIF_DASAR");
											if ($TARIF_DASAR != $TARIF_DASAR_CFS) {
												$chektarif .= 'not';
											} else {
												$chektarif .= 'sama';
											}
										}
										if (strpos($chektarif, 'not') !== FALSE) {
											$RES = 'REJECT';
											$RESTBL .= 'REJECT';
											$message .= '<RESPON>' . $RES . '</RESPON>';
											$message .= '<ALASAN_REJECT>';
										} else {
											$RES = 'ACCEPT';
											$RESTBL .= 'ACCEPT';
											$message .= '<RESPON>' . $RES . '</RESPON>';
										}
									} elseif ($countTarif == 1) {
										$TARIF_DASAR = trim($detil['TARIF']['_c']['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['TARIF_DASAR']['_v'])) . "";
										$KODE = trim($detil['TARIF']['_c']['KODE_TARIF']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['KODE_TARIF']['_v'])) . "";
										$SQLKode = "SELECT a.TARIF_DASAR FROM reff_billing_cfs a WHERE a.KODE_BILL = '" . $KODE . "'";
										$QueryKode = $conn->query($SQLKode);
										$QueryKode->next();
										$TARIF_DASAR_CFS = $QueryKode->get("TARIF_DASAR");
										if ($TARIF_DASAR != $TARIF_DASAR_CFS) {
											$RES = 'REJECT';
											$RESTBL .= 'REJECT';
											$message .= '<RESPON>' . $RES . '</RESPON>';
										} else {
											$RES = 'ACCEPT';
											$RESTBL .= 'ACCEPT';
											$message .= '<RESPON>' . $RES . '</RESPON>';
										}
									}

									if ($countTarif > 1) {

										for ($i = 0; $i < $countTarif; $i++) {
											$TARIF_DASAR = trim($detil['TARIF'][$i]['_c']['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['TARIF_DASAR']['_v'])) . "";
											$KODE = trim($detil['TARIF'][$i]['_c']['KODE_TARIF']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['KODE_TARIF']['_v'])) . "";

											$SQLKode = "SELECT a.TARIF_DASAR FROM reff_billing_cfs a WHERE a.KODE_BILL = '" . $KODE . "'";
											$QueryKode = $conn->query($SQLKode);
											$QueryKode->next();
											$TARIF_DASAR_CFS = $QueryKode->get("TARIF_DASAR");
											if ($TARIF_DASAR != $TARIF_DASAR_CFS) {
												$message .= '<ALASAN_REJECT>';
												$message .= '<KD_TARIF>' . $KODE . '</KD_TARIF>';
												$message .= '<KETERANGAN>Harga Tarif Dasar Tidak Sama</KETERANGAN>';
												$message .= '</ALASAN_REJECT>';
											}
										}
									} elseif ($countTarif == 1) {
										$TARIF_DASAR = trim($detil['TARIF']['_c']['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['TARIF_DASAR']['_v'])) . "";
										$KODE = trim($detil['TARIF']['_c']['KODE_TARIF']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['KODE_TARIF']['_v'])) . "";
										$SQLKode = "SELECT a.TARIF_DASAR FROM reff_billing_cfs a WHERE a.KODE_BILL = '" . $KODE . "'";
										$QueryKode = $conn->query($SQLKode);
										$QueryKode->next();
										$TARIF_DASAR_CFS = $QueryKode->get("TARIF_DASAR");
										if ($TARIF_DASAR != $TARIF_DASAR_CFS) {
											$message .= '<ALASAN_REJECT>';
											$message .= '<KD_TARIF>' . $KODE . '</KD_TARIF>';
											$message .= '<KETERANGAN>Harga Tarif Dasar Tidak Sama</KETERANGAN>';
											$message .= '</ALASAN_REJECT>';
										}
									}
									//UPDATE NANDA 26/11/17
									InsertBillingDetail($detil, $loadBillingHeaderxml, $countTarif, $RESTRUE, $countBilling, $IDOrder, $JENIS_BILLING);
									$SQLsub = "select sum(A.TOTAL) as SUBTOT,B.SUBTOTAL from t_billing_cfsdtl A join t_billing_cfshdr B on A.ID=B.ID
									WHERE B.ID = '" . $IDOrder . "'";
									$Querysub = $conn->query($SQLsub);
									if ($Querysub->size() > 0) {
										$Querysub->next();
										$SUBTOT = $Querysub->get("SUBTOT");
										$SUBTOT2 = $Querysub->get("SUBTOTAL");
										if ($SUBTOT == $SUBTOT2) {
											
										} else {
											$RESTBL .= "REJECT";
											$message .= '<ALASAN_REJECT>';
											$message .= '<KETERANGAN>Subtotal Tidak Sama</KETERANGAN>';
											$message .= '</ALASAN_REJECT>';
										}
									} else {
										$RESTBL .= "REJECT";
									}
									$message .= '</DETIL>';
									$message .= '</LOADBILLING>';
								}
								if (strpos($RESTBL, 'REJECT') !== FALSE) {
									$RESTRUE = 'REJECT';
									$FLAG = 'N';
									$SQLUpdateBillingOrder = "UPDATE t_order_hdr SET KD_STATUS = '400'  WHERE NO_ORDER = '" . $NO_ORDER . "'"; //ada
									// print_r($SQLUpdateBillingOrder);die();
									$Execute = $conn->execute($SQLUpdateBillingOrder);
								} else {
									$RESTRUE = 'ACCEPT';
									$FLAG = 'Y';
									$SQLUpdateBillingHDR = "UPDATE t_billing_cfshdr SET FLAG_APPROVE = 'N' WHERE NO_ORDER = '" . $NO_ORDER . "'";
									$Execute = $conn->execute($SQLUpdateBillingHDR);
									$SQLUpdateBillingOrder = "UPDATE t_order_hdr SET KD_STATUS = '500', TGL_STATUS = NOW() WHERE NO_ORDER = '" . $NO_ORDER . "'"; //ada
									$Execute = $conn->execute($SQLUpdateBillingOrder);
								}
								$SQLcek = "SELECT NO_INVOICE FROM t_billing_cfshdr WHERE NO_ORDER = '". $NO_ORDER ."'";
								$Querycek = $conn->query($SQLcek);
								if ($Query->size() > 0) {
									$Query->next();
									if($Query->get("NO_INVOICE") != ""){
										$SQLUpdateKdStatus = "UPDATE t_order_hdr SET KD_STATUS = '700', TGL_STATUS = NOW() WHERE NO_ORDER = '" . $NO_ORDER . "'"; //ada
										$Execute = $conn->execute($SQLUpdateKdStatus);
									} 
								}
								// print_r($SQLUpdateBillingOrder);die();

								$message .= '</DOCUMENT>';
								$SQLUpdateBillingHDR = "UPDATE t_billing_cfshdr SET KD_ALASAN_BILLING = '" . $RESTRUE . "',FLAG_APPROVE = '".$FLAG."' WHERE NO_ORDER = '" . $NO_ORDER . "' AND ID = '". $IDOrder ."'";
								$Execute = $conn->execute($SQLUpdateBillingHDR);
							}else {
								$message .= '<LOADBILLING>';
								$message .= '<HEADER>';
								$message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
								$message .= '</HEADER>';
								$message .= '<DETIL>';
								$message .= '<RESPON>ACCEPT</RESPON>';
								$message .= '</DETIL>';
								$message .= '</LOADBILLING>';
								$SQL = "UPDATE app_log_services SET FL_USED = '1', KETERANGAN = 'Order sudah lunas', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
								$Execute = $conn->execute($SQL);
							}
						}
                        $SQLUpdateMailbox = "UPDATE mailbox SET KD_STATUS = '300' WHERE ID = '" . $ID_LOG . "'";
                        $Execute = $conn->execute($SQLUpdateMailbox);
                    } elseif ($countBilling == 1) {
                        $LOADBILLING = $loadBillingxml['BILLING']['_c'];
                        // print_r($LOADBILLING);die();	
                        $header = $LOADBILLING['HEADER']['_c'];
                        $detil = $xml['DETIL']['_c'];
                        $countTarif = 0;
                        $countTarif = count($detil['TARIF']);
                        $JENIS_BILLING = trim($loadBillingHeaderxml['JENIS_BILLING']['_v']) == "" ? "NULL" : "" . strtoupper(trim($loadBillingHeaderxml['JENIS_BILLING']['_v'])) . "";
						$NO_ORDER = trim($loadBillingHeaderxml['NO_ORDER']['_v']) == "" ? "NULL" : "" . strtoupper(trim($loadBillingHeaderxml['NO_ORDER']['_v'])) . "";
                        // print_r($JENIS_BILLING);die();
                        $checkorder = $conn->query("SELECT ID FROM t_order_hdr WHERE NO_ORDER = '" . $NO_ORDER . "'");
						if ($checkorder->size() == 0){
							$message = '<?xml version="1.0" encoding="UTF-8"?>';
							$message .= '<DOCUMENT>';
							$message .= '<LOADBILLING>';
							$message .= '<RESPON>Nomor Order Tidak Ditemukan.</RESPON>';
							$message .= '</LOADBILLING>';
							$message .= '</DOCUMENT>';
						} else {
							$checkbil = $conn->query("SELECT ID FROM t_billing_cfshdr WHERE NO_ORDER = '" . $NO_ORDER . "' AND NO_INVOICE IS NOT NULL");
							if ($checkbil->size() == 0) {
								$IDOrder = InsertBilling($loadBillingHeaderxml, $countTarif, $countBilling);
								// print_r($IDOrder);die();
								$NO_CONT = trim($detil['NO_CONT']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['NO_CONT']['_v'])) . "";
								// print_r($NO_CONT);die();
								$message = '<?xml version="1.0" encoding="UTF-8"?>';
								$message .= '<DOCUMENT>';
								$message .= '<LOADBILLING>';
								$message .= '<HEADER>';
								$message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
								$message .= '</HEADER>';
								$message .= '<DETIL>';
								if ($countTarif > 1) {
									$chektarif = '';
									for ($i = 0; $i < $countTarif; $i++) {
										$TARIF_DASAR = trim($detil['TARIF'][$i]['_c']['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['TARIF_DASAR']['_v'])) . "";
										$KODE = trim($detil['TARIF'][$i]['_c']['KODE_TARIF']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['KODE_TARIF']['_v'])) . "";
										$SQLKode = "SELECT a.TARIF_DASAR FROM reff_billing_cfs a WHERE a.KODE_BILL = '" . $KODE . "'";
										$QueryKode = $conn->query($SQLKode);
										$QueryKode->next();
										$TARIF_DASAR_CFS = $QueryKode->get("TARIF_DASAR");
										if ($TARIF_DASAR != $TARIF_DASAR_CFS) {
											$chektarif .= 'not';
										} else {
											$chektarif .= 'sama';
										}
									}
									if (strpos($chektarif, 'not') !== FALSE) {
										$RES = 'REJECT';
										$RESTBL .= 'REJECT';
										$message .= '<RESPON>' . $RES . '</RESPON>';
										
									} else {
										$RES = 'ACCEPT';
										$RESTBL .= 'ACCEPT';
										$message .= '<RESPON>' . $RES . '</RESPON>';
									}
								} elseif ($countTarif == 1) {
									$TARIF_DASAR = trim($detil['TARIF']['_c']['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['TARIF_DASAR']['_v'])) . "";
									$KODE = trim($detil['TARIF']['_c']['KODE_TARIF']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['KODE_TARIF']['_v'])) . "";
									$SQLKode = "SELECT a.TARIF_DASAR FROM reff_billing_cfs a WHERE a.KODE_BILL = '" . $KODE . "'";
									$QueryKode = $conn->query($SQLKode);
									$QueryKode->next();
									$TARIF_DASAR_CFS = $QueryKode->get("TARIF_DASAR");
									if ($TARIF_DASAR != $TARIF_DASAR_CFS) {
										$RES = 'REJECT';
										$RESTBL .= 'REJECT';
										$message .= '<RESPON>' . $RES . '</RESPON>';
										$message .= '<ALASAN_REJECT>';
									} else {
										$RES = 'ACCEPT';
										$RESTBL .= 'ACCEPT';
										$message .= '<RESPON>' . $RES . '</RESPON>';
									}
								}
								if ($countTarif > 1) {
									for ($i = 0; $i < $countTarif; $i++) {
										$TARIF_DASAR = trim($detil['TARIF'][$i]['_c']['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['TARIF_DASAR']['_v'])) . "";
										$KODE = trim($detil['TARIF'][$i]['_c']['KODE_TARIF']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['KODE_TARIF']['_v'])) . "";
										$SQLKode = "SELECT a.TARIF_DASAR FROM reff_billing_cfs a WHERE a.KODE_BILL = '" . $KODE . "'";
										$QueryKode = $conn->query($SQLKode);
										$QueryKode->next();
										$TARIF_DASAR_CFS = $QueryKode->get("TARIF_DASAR");
										if ($TARIF_DASAR != $TARIF_DASAR_CFS) {
											$message .= '<ALASAN_REJECT>';
											$message .= '<KD_TARIF>' . $KODE . '</KD_TARIF>';
											$message .= '<KETERANGAN>Harga Tarif Dasar Tidak Sama</KETERANGAN>';
											$message .= '</ALASAN_REJECT>';
										}
									}
								} elseif ($countTarif == 1) {
									$TARIF_DASAR = trim($detil['TARIF']['_c']['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['TARIF_DASAR']['_v'])) . "";
									$KODE = trim($detil['TARIF']['_c']['KODE_TARIF']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['KODE_TARIF']['_v'])) . "";
									$SQLKode = "SELECT a.TARIF_DASAR FROM reff_billing_cfs a WHERE a.KODE_BILL = '" . $KODE . "'";
									$QueryKode = $conn->query($SQLKode);
									$QueryKode->next();
									$TARIF_DASAR_CFS = $QueryKode->get("TARIF_DASAR");
									if ($TARIF_DASAR != $TARIF_DASAR_CFS) {
										$message .= '<ALASAN_REJECT>';
										$message .= '<KD_TARIF>' . $KODE . '</KD_TARIF>';
										$message .= '<KETERANGAN>Harga Tarif Dasar Tidak Sama</KETERANGAN>';
										$message .= '</ALASAN_REJECT>';
									}
								}
								//UPDATE NANDA 26/11/17
								InsertBillingDetail($detil, $loadBillingHeaderxml, $countTarif, $RESTRUE, $countBilling, $IDOrder, $JENIS_BILLING);
								$SQLsub = "select sum(A.TOTAL) as SUBTOT,B.SUBTOTAL from t_billing_cfsdtl A join t_billing_cfshdr B on A.ID=B.ID
								WHERE B.ID = '" . $IDOrder . "'";
								$Querysub = $conn->query($SQLsub);
								if ($Querysub->size() > 0) {
									$Querysub->next();
									$SUBTOT = $Querysub->get("SUBTOT");
									$SUBTOT2 = $Querysub->get("SUBTOTAL");
									if ($SUBTOT == $SUBTOT2) {
										
									} else {
										$RESTBL .= "REJECT";
										$message .= '<ALASAN_REJECT>';
										$message .= '<KETERANGAN>Subtotal Tidak Sama</KETERANGAN>';
										$message .= '</ALASAN_REJECT>';
									}
								} else {
									$RESTBL .= "REJECT";
								}
								$message .= '</DETIL>';
								$message .= '</LOADBILLING>';
								$message .= '</DOCUMENT>';
								if (strpos($RESTBL, 'REJECT') !== FALSE) {
									$RESTRUE = 'REJECT';
									$SQLUpdateBillingOrder = "UPDATE t_order_hdr SET KD_STATUS = '400' WHERE NO_ORDER = '" . $NO_ORDER . "'"; //ada
									$FLAG = 'N';
									$Execute = $conn->execute($SQLUpdateBillingOrder);
								} else {
									$RESTRUE = 'ACCEPT';
									$FLAG = 'Y';
									$SQLUpdateBillingHDR = "UPDATE t_billing_cfshdr SET FLAG_APPROVE = 'N' WHERE NO_ORDER = '" . $NO_ORDER . "'";
									$Execute = $conn->execute($SQLUpdateBillingHDR);
									$SQLUpdateBillingOrder = "UPDATE t_order_hdr SET KD_STATUS = '500', TGL_STATUS = NOW() WHERE NO_ORDER = '" . $NO_ORDER . "'"; //ada
									$Execute = $conn->execute($SQLUpdateBillingOrder);
								}
								$SQLcek = "SELECT NO_INVOICE FROM t_billing_cfshdr WHERE NO_ORDER = '". $NO_ORDER ."'";
								$Querycek = $conn->query($SQLcek);
								if ($Query->size() > 0) {
									$Query->next();
									if($Query->get("NO_INVOICE") != ""){
										$SQLUpdateKdStatus = "UPDATE t_order_hdr SET KD_STATUS = '700', TGL_STATUS = NOW() WHERE NO_ORDER = '" . $NO_ORDER . "'"; //ada
										$Execute = $conn->execute($SQLUpdateKdStatus);
									} 
								}
								// print_r($countTarif);die();

								$SQLUpdateBillingHDR = "UPDATE t_billing_cfshdr SET KD_ALASAN_BILLING = '" . $RESTRUE . "',FLAG_APPROVE = '".$FLAG."' WHERE NO_ORDER = '" . $NO_ORDER . "' AND ID = '". $IDOrder ."'";
								$Execute = $conn->execute($SQLUpdateBillingHDR);
							}else{
								$message .= '<LOADBILLING>';
								$message .= '<HEADER>';
								$message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
								$message .= '</HEADER>';
								$message .= '<DETIL>';
								$message .= '<RESPON>ACCEPT</RESPON>';
								$message .= '</DETIL>';
								$message .= '</LOADBILLING>';
								$SQL = "UPDATE app_log_services SET FL_USED = '1', KETERANGAN = 'Order sudah lunas', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
								$Execute = $conn->execute($SQL);
							}
                        }
                        $SQLUpdateMailbox = "UPDATE mailbox SET KD_STATUS = '300' WHERE ID = '" . $ID_LOG . "'";
                        $Execute = $conn->execute($SQLUpdateMailbox);
                    }
                } else {
					$message = '<?xml version="1.0" encoding="UTF-8"?>';
					$message .= '<DOCUMENT>';
					$message .= '<LOADBILLING>';
					$message .= '<RESPON>Format fStream SALAH!!!</RESPON>';
					$message .= '</LOADBILLING>';
					$message .= '</DOCUMENT>';
                }
            }
        } else {
            $message = 'data tidak ada.';
        }
    } else {
        $message = "Proses GAGAL Tersimpan di Portal CFS";
    }
    $return = $message;
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function LoadBillingGudang($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    // print_r("ok");die();
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'LoadBillingGudang', $fStream);
    if ($Username == "TES" && $Password == "TES") {
        return $fStream;
    }
	$cek = checkUser($Username,$Password);
	if (!$cek['return']) {
		return $cek['message'];
	}

    $STR_DATA = str_replace('&', '&amp;', $fStream);

    $message = '<?xml version="1.0" encoding="UTF-8"?>';
    $message .= '<DOCUMENT>';

	libxml_use_internal_errors(true);

	$doc = simplexml_load_string($STR_DATA);
	$xml = explode("\n", $STR_DATA);
	$respon="";

	if (!$doc) {
		$errors = libxml_get_errors();
		foreach ($errors as $error) {
			$respon .= display_xml_error($error, $xml);
		}

		libxml_clear_errors();
		$message .= '<LOADBILLING>';
		$message .= '<RESPON>'.$respon.'</RESPON>';
		$message .= '</LOADBILLING>';
		$SQL = "UPDATE app_log_services SET FL_USED = '1', KETERANGAN = 'Error XML', WK_USED = NOW() WHERE ID = '" . $IDLogServices . "'";
		$Execute = $conn->execute($SQL);
	}else{
		$xml = xml2ary($STR_DATA);
		if (count($xml) > 0) {
			$xml = $xml['DOCUMENT']['_c'];
			$countBilling = 0;
			$countBilling = count($xml['LOADBILLINGGUDANG']);
			if ($countBilling > 1) {
				for ($c = 0; $c < $countBilling; $c++) {
					$billing = $xml['LOADBILLINGGUDANG'][$c]['_c'];
					$message .= insertorder($billing, $IDLogServices);
				}
			} elseif ($countBilling == 1) {
				$billing = $xml['LOADBILLINGGUDANG']['_c'];
				$message .= insertorder($billing, $IDLogServices);
			} else {
				$message .= '<LOADBILLING>';
				$message .= '<RESPON>Format fStream SALAH!!!</RESPON>';
				$message .= '</LOADBILLING>';
			}
		} else {
			$message .= '<LOADBILLING>';
			$message .= '<RESPON>Format fStream SALAH!!!</RESPON>';
			$message .= '</LOADBILLING>';
		}
	}
    $message .= '</DOCUMENT>';
    $return = $message;
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetResponPembayaranCFS($Username, $Password, $Kd_Gudang) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';

    $kode = ($Kd_Gudang == 'RAYA') ? '01' : '02';
	$del=0;	
	if($Kd_Gudang == 'BAND'){
		$SQLUSER = "SELECT A.ID,A.NO_ORDER,A.NO_INVOICE,A.TGL_UPDATE,A.TOTAL FROM  t_billing_cfshdr A 
			WHERE A.NO_ORDER LIKE '1002%' AND A.KD_ALASAN_BILLING='ACCEPT' AND A.NO_INVOICE IS NOT NULL AND A.FL_SEND='100' ORDER BY A.ID ASC LIMIT 1";
		$QueryUser = $conn->query($SQLUSER);

		if ($QueryUser->size() == 0) {
			$del++;
			$message = '<?xml version="1.0" encoding="UTF-8"?>';
			$message .= '<DOCUMENT>';
			$message .= '<RESPONPEMBAYARANCFS>BELUM ADA DATA BARU</RESPONPEMBAYARANCFS>';
			$message .= '</DOCUMENT>';
			$return = $message;
		} else {
			$message = '<?xml version="1.0" encoding="UTF-8"?>';
			$message .= '<DOCUMENT>';
			while ($QueryUser->next()) {
				$message .= '<RESPONPEMBAYARANCFS>';
				$message .= '<NO_ORDER>' . $QueryUser->get("NO_ORDER") . '</NO_ORDER>';
				$message .= '<NO_INVOICE>' . $QueryUser->get("NO_INVOICE") . '</NO_INVOICE>';
				$message .= '<TGL_BAYAR>' . $QueryUser->get("TGL_UPDATE") . '</TGL_BAYAR>';
				$message .= '<TOTAL_BAYAR>' . $QueryUser->get("TOTAL") . '</TOTAL_BAYAR>';
				$message .= '</RESPONPEMBAYARANCFS>';
				$SQL = "UPDATE t_billing_cfshdr SET FL_SEND='200' WHERE ID='". $QueryUser->get("ID") ."'";
				$Execute = $conn->execute($SQL);
			}
			$message .= '</DOCUMENT>';
			$IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'GetResponPembayaranCFS', $Kd_Gudang);
			$return = $message;
			updateLogServices($IDLogServices, $return);
		}
	}else{
		$del++;
        $message = '<?xml version="1.0" encoding="UTF-8"?>';
        $message .= '<DOCUMENT>';
        $message .= '<RESPONPEMBAYARANCFS>KODE REQUEST SALAH!</RESPONPEMBAYARANCFS>';
        $message .= '</DOCUMENT>';
        $return = $message;
	}

    $conn->disconnect();
    return $return;
}

function OrderPengeluaranBarang($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
	$del=0;
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'OrderPengeluaranBarang', $fStream);
    if (strpos($fStream, '?xml') !== FALSE) {

    }else{
		$del++;
        $message = '<?xml version="1.0" encoding="UTF-8"?>';
        $message .= '<DOCUMENT>';
        $message .= '<ORDERPENGELUARANBARANG>';
        $message .= '<RESPON>Format fStream SALAH!!!</RESPON>';
        $message .= '</ORDERPENGELUARANBARANG>';
        $message .= '</DOCUMENT>';
	}
    $xml = str_replace('&', '', $fStream);
    // echo $xml;die();
    $SQLlogin = "SELECT ID FROM t_organisasi WHERE USERNAME_TPSONLINE_BC = '" . $Username . "' AND PASSWORD_TPSONLINE_BC = '" . $Password . "'";
    // echo $SQLlogin;die();
    $Query = $conn->query($SQLlogin);
    if ($Query->size() > 0) {
        $Query->next();
        $KD_ORG_SENDER = $Query->get("ID");
		if($KD_ORG_SENDER=='108'){
			return $fStream;
		}
    } else {
        $KD_ORG_SENDER = "";
		return 'Username Anda ditolak!';
    }
    $STR_DATA = $fStream;
    $xml = xml2ary($STR_DATA);
    // print_r($xml);die();

    if (count($xml) > 0) {
        $xml = $xml['DOCUMENT']['_c'];
        // print_r($xml);die();
        $OrderPB = $xml['ORDERPENGELUARANBARANG']['_c'];
        // print_r($OrderPB);die();
        $KD_GUDANG = trim($OrderPB['KD_GUDANG']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['KD_GUDANG']['_v'])) . "";
        // print_r($KD_GUDANG);die();
        $SQLHeader = "SELECT A.ID, A.NO_ORDER, A.JENIS_BILLING, A.JENIS_BAYAR, DATE_FORMAT(A.TGL_KELUAR,'%Y%m%d') AS TGL_KELUAR, A.NO_MASTER_BL_AWB, 
        DATE_FORMAT(A.TGL_MASTER_BL_AWB,'%Y%m%d') AS TGL_MASTER_BL_AWB, A.NO_BL_AWB, DATE_FORMAT(A.TGL_BL_AWB,'%Y%m%d') AS TGL_BL_AWB, A.NO_DO, 
        DATE_FORMAT(A.TGL_DO,'%Y%m%d') AS TGL_DO, DATE_FORMAT(A.TGL_EXPIRED_DO,'%Y%m%d') AS TGL_EXPIRED_DO, A.NAMA_FORWARDER, A.NPWP_FORWARDER, A.ALAMAT_FORWARDER, 
        A.NO_PERMOHONAN_CFS, A.KD_TPS_ASAL, A.KD_TPS_TUJUAN, A.KD_GUDANG_ASAL, A.KD_GUDANG_TUJUAN, A.NO_BC11, DATE_FORMAT(A.TGL_BC11,'%Y%m%d') AS TGL_BC11, A.NO_CONT_ASAL, 
        IFNULL(A.KD_DOK_INOUT,A.KODE_DOK) AS KD_DOK_INOUT, IFNULL(A.NO_DOK_INOUT,A.NO_SPPB) AS NO_DOK_INOUT, IFNULL(DATE_FORMAT(A.TGL_DOK_INOUT,'%Y%m%d'),DATE_FORMAT(A.TGL_SPPB,'%Y%m%d')) AS TGL_DOK_INOUT, A.CONSIGNEE, A.NPWP_CONSIGNEE, A.NM_ANGKUT, A.NO_VOYAGE,A.JENIS_TRANSAKSI,A.TGL_KELUAR_LAMA , B.NO_POLISI_TRUCK 
        FROM t_order_hdr A INNER JOIN t_order_kms B ON A.ID = B.ID WHERE A.KD_GUDANG_TUJUAN = '" . $KD_GUDANG . "' AND A.KD_STATUS = '200'";




        $QueryHeader = $conn->query($SQLHeader);
        // print_r($QueryHeader->size());die();
        if ($QueryHeader->size() > 1) {
            $message = '<?xml version="1.0" encoding="UTF-8"?>';
            $message .= '<DOCUMENT>';
            for ($i = 0; $i < $QueryHeader->size(); $i++) {
                $QueryHeader->next();
                $ID = $QueryHeader->get("ID");
                $NO_ORDER = $QueryHeader->get("NO_ORDER");
                $JENIS_BILLING = $QueryHeader->get("JENIS_BILLING");
                $JENIS_BAYAR = $QueryHeader->get("JENIS_BAYAR");
                $TGL_KELUAR = $QueryHeader->get("TGL_KELUAR");
                $NO_MASTER_BL_AWB = $QueryHeader->get("NO_MASTER_BL_AWB");
                $TGL_MASTER_BL_AWB = $QueryHeader->get("TGL_MASTER_BL_AWB");
                $NO_BL_AWB = $QueryHeader->get("NO_BL_AWB");
                $TGL_BL_AWB = $QueryHeader->get("TGL_BL_AWB");
                $NO_DO = $QueryHeader->get("NO_DO");
                $TGL_DO = $QueryHeader->get("TGL_DO");
                $TGL_EXPIRED_DO = $QueryHeader->get("TGL_EXPIRED_DO");
 				$NAMA_FORWARDER = str_replace("'", '', str_replace('&', '&amp;', $QueryHeader->get("NAMA_FORWARDER")));
                $NPWP_FORWARDER = $QueryHeader->get("NPWP_FORWARDER");
				$ALAMAT_FORWARDER = str_replace("'", '', str_replace('&', '&amp;', $QueryHeader->get("ALAMAT_FORWARDER")));
                $NO_PERMOHONAN_CFS = $QueryHeader->get("NO_PERMOHONAN_CFS");
                $KD_TPS_ASAL = $QueryHeader->get("KD_TPS_ASAL");
                $KD_TPS_TUJUAN = $QueryHeader->get("KD_TPS_TUJUAN");
                $KD_GUDANG_ASAL = $QueryHeader->get("KD_GUDANG_ASAL");
                $KD_GUDANG_TUJUAN = $QueryHeader->get("KD_GUDANG_TUJUAN");
                $NO_BC11 = $QueryHeader->get("NO_BC11");
                $TGL_BC11 = $QueryHeader->get("TGL_BC11");
                $NO_CONT_ASAL = $QueryHeader->get("NO_CONT_ASAL");
                $KD_DOK_INOUT = $QueryHeader->get("KD_DOK_INOUT");
                $NO_DOK = $QueryHeader->get("NO_DOK_INOUT");
                $TGL_DOK = $QueryHeader->get("TGL_DOK_INOUT");
				$CONSIGNEE = str_replace("'", '', str_replace('&', '&amp;', $QueryHeader->get("CONSIGNEE")));
                $NPWP_CONSIGNEE = $QueryHeader->get("NPWP_CONSIGNEE");
                $NM_ANGKUT = $QueryHeader->get("NM_ANGKUT");
                $NO_VOYAGE = $QueryHeader->get("NO_VOYAGE");
                $TGL_TIBA = $QueryHeader->get("TGL_TIBA");
                $JENIS_TRANSAKSI = $QueryHeader->get("JENIS_TRANSAKSI");
                $TGL_KELUAR_LAMA = $QueryHeader->get("TGL_KELUAR_LAMA");
                $NO_POLISI_TRUCK = $QueryHeader->get("NO_POLISI_TRUCK");

                //create xml


                $message .= '<ORDERPENGELUARANBARANG>';
                $message .= '<HEADER>';
                $message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
                $message .= '<JENIS_BILLING>' . $JENIS_BILLING . '</JENIS_BILLING>';
                $message .= '<JENIS_BAYAR>' . $JENIS_BAYAR . '</JENIS_BAYAR>';
                $message .= '<JENIS_TRANSAKSI>' . $JENIS_TRANSAKSI . '</JENIS_TRANSAKSI>';
                $message .= '<TGL_KELUAR_LAMA>' . $TGL_KELUAR_LAMA . '</TGL_KELUAR_LAMA>';
                $message .= '<TGL_KELUAR>' . $TGL_KELUAR . '</TGL_KELUAR>';
                $message .= '<NO_MASTER_BL_AWB>' . $NO_MASTER_BL_AWB . '</NO_MASTER_BL_AWB>';
                $message .= '<TGL_MASTER_BL_AWB>' . $TGL_MASTER_BL_AWB . '</TGL_MASTER_BL_AWB>';
                $message .= '<NO_BL_AWB>' . $NO_BL_AWB . '</NO_BL_AWB>';
                $message .= '<TGL_BL_AWB>' . $TGL_BL_AWB . '</TGL_BL_AWB>';
                $message .= '<NO_DO>' . $NO_DO . '</NO_DO>';
                $message .= '<TGL_DO>' . $TGL_DO . '</TGL_DO>';
                $message .= '<TGL_EXPIRED_DO>' . $TGL_EXPIRED_DO . '</TGL_EXPIRED_DO>';
                $message .= '<NAMA_FORWARDER>' . $NAMA_FORWARDER . '</NAMA_FORWARDER>';
                $message .= '<NPWP_FORWARDER>' . $NPWP_FORWARDER . '</NPWP_FORWARDER>';
                $message .= '<ALAMAT_FORWARDER>' . $ALAMAT_FORWARDER . '</ALAMAT_FORWARDER>';
                $message .= '<NO_PERMOHONAN_CFS>' . $NO_PERMOHONAN_CFS . '</NO_PERMOHONAN_CFS>';
                $message .= '<KD_TPS_ASAL>' . $NKD_TPS_ASALO_ORDER . '</KD_TPS_ASAL>';
                $message .= '<KD_TPS_TUJUAN>' . $KD_TPS_TUJUAN . '</KD_TPS_TUJUAN>';
                $message .= '<KD_GUDANG_ASAL>' . $KD_GUDANG_ASAL . '</KD_GUDANG_ASAL>';
                $message .= '<KD_GUDANG_TUJUAN>' . $KD_GUDANG_TUJUAN . '</KD_GUDANG_TUJUAN>';
                $message .= '<NO_BC11>' . $NO_BC11 . '</NO_BC11>';
                $message .= '<TGL_BC11>' . $TGL_BC11 . '</TGL_BC11>';
                $message .= '<NO_CONT_ASAL>' . $NO_CONT_ASAL . '</NO_CONT_ASAL>';
                $message .= '<KD_DOK_INOUT>' . $KD_DOK_INOUT . '</KD_DOK_INOUT>';
                $message .= '<NO_DOK>' . $NO_DOK . '</NO_DOK>';
                $message .= '<TGL_DOK>' . $TGL_DOK . '</TGL_DOK>';
                $message .= '<CONSIGNEE>' . $CONSIGNEE . '</CONSIGNEE>';
                $message .= '<NPWP_CONSIGNEE>' . $NPWP_CONSIGNEE . '</NPWP_CONSIGNEE>';
                $message .= '<NM_ANGKUT>' . $NM_ANGKUT . '</NM_ANGKUT>';
                $message .= '<NO_VOYAGE>' . $NO_VOYAGE . '</NO_VOYAGE>';
                $message .= '<TGL_TIBA>' . $TGL_TIBA . '</TGL_TIBA>';
                $message .= '<NO_POLISI_TRUCK>' . $NO_POLISI_TRUCK . '</NO_POLISI_TRUCK>';
                $message .= '</HEADER>';

                $SQLDetilCont = "SELECT A.NO_CONT, A.KD_CONT_UKURAN, A.KD_CONT_JENIS FROM t_order_cont A WHERE A.ID = '" . $ID . "'";
                $QueryDetilCont = $conn->query($SQLDetilCont);
                if ($QueryDetilCont->size() > 0) {
                    if ($QueryDetilCont->size() > 1) {
                        $message .= '<DETIL_CONT>';
                        while ($QueryDetilCont->next()) {
                            $NO_CONT = $QueryDetilCont->get("NO_CONT");
                            $KD_UK_CONT = $QueryDetilCont->get("KD_CONT_UKURAN");
                            $message .= '<CONTAINER>';
                            $message .= '<NO_CONT>' . $NO_CONT . '</NO_CONT>';
                            $message .= '<KD_CONT_UKURAN>' . $KD_UK_CONT . '</KD_CONT_UKURAN>';
                            $message .= '</CONTAINER>';
                        }
                        $message .= '</DETIL_CONT>';
                    } elseif ($QueryDetilCont->size() == 1) {
                        $QueryDetilCont->next();
                        $NO_CONT = $QueryDetilCont->get("NO_CONT");
                        $KD_UK_CONT = $QueryDetilCont->get("KD_CONT_UKURAN");
                        $message .= '<DETIL_CONT>';
                        $message .= '<CONTAINER>';
                        $message .= '<NO_CONT>' . $NO_CONT . '</NO_CONT>';
                        $message .= '<KD_CONT_UKURAN>' . $KD_UK_CONT . '</KD_CONT_UKURAN>';
                        $message .= '</CONTAINER>';
                        $message .= '</DETIL_CONT>';
                    }
                } else {
                    $message .= '<DETIL_CONT>';
                    $message .= '<CONTAINER>';
                    $message .= '<NO_CONT></NO_CONT>';
                    $message .= '<KD_CONT_UKURAN></KD_CONT_UKURAN>';
                    $message .= '</CONTAINER>';
                    $message .= '</DETIL_CONT>';
                }

                $SQLDetilKms = "SELECT A.JNS_KMS, A.MERK_KMS, A.JML_KMS FROM t_order_kms A WHERE A.ID = '" . $ID . "'";
                // print_r($SQLDetilKms);die();
                $QueryDetilKms = $conn->query($SQLDetilKms);
                if ($QueryDetilKms->size() > 0) {
                    if ($QueryDetilKms->size() > 1) {
                        $message .= '<DETIL_KMS>';
                        while ($QueryDetilKms->next()) {
                            $JNS_KMS = $QueryDetilKms->get("JNS_KMS");
                            $MERK_KMS = str_replace('&', '&amp;', $QueryDetilKms->get("MERK_KMS"));
                            $JML_KMS = $QueryDetilKms->get("JML_KMS");
                            $message .= '<KEMASAN>';
                            $message .= '<JNS_KMS>' . $JNS_KMS . '</JNS_KMS>';
                            $message .= '<MERK_KMS>' . $MERK_KMS . '</MERK_KMS>';
                            $message .= '<JML_KMS>' . $JML_KMS . '</JML_KMS>';
                            $message .= '</KEMASAN>';
                        }
                        $message .= '</DETIL_KMS>';
                    } elseif ($QueryDetilKms->size() == 1) {
                        $QueryDetilKms->next();
                        $JNS_KMS = $QueryDetilKms->get("JNS_KMS");
						$MERK_KMS = str_replace('&', '&amp;', $QueryDetilKms->get("MERK_KMS"));
                        $JML_KMS = $QueryDetilKms->get("JML_KMS");
                        $message .= '<DETIL_KMS>';
                        $message .= '<KEMASAN>';
                        $message .= '<JNS_KMS>' . $JNS_KMS . '</JNS_KMS>';
                        $message .= '<MERK_KMS>' . $MERK_KMS . '</MERK_KMS>';
                        $message .= '<JML_KMS>' . $JML_KMS . '</JML_KMS>';
                        $message .= '</KEMASAN>';
                        $message .= '</DETIL_KMS>';
                    }
                } else {
                    $message .= '<DETIL_KMS>';
                    $message .= '<KEMASAN>';
                    $message .= '<JNS_KMS></JNS_KMS>';
                    $message .= '<MERK_KMS></MERK_KMS>';
                    $message .= '<JML_KMS></JML_KMS>';
                    $message .= '</KEMASAN>';
                    $message .= '</DETIL_KMS>';
                }

                $message .= '</ORDERPENGELUARANBARANG>';

                // print_r($ID);die();
                updateOrderPBarang($ID);
            }
            $message .= '</DOCUMENT>';
        } elseif ($QueryHeader->size() == 1) {
            $QueryHeader->next();
            $ID = $QueryHeader->get("ID");
            $NO_ORDER = $QueryHeader->get("NO_ORDER");
            $JENIS_BILLING = $QueryHeader->get("JENIS_BILLING");
            $JENIS_BAYAR = $QueryHeader->get("JENIS_BAYAR");
            $TGL_KELUAR = $QueryHeader->get("TGL_KELUAR");
            $NO_MASTER_BL_AWB = $QueryHeader->get("NO_MASTER_BL_AWB");
            $TGL_MASTER_BL_AWB = $QueryHeader->get("TGL_MASTER_BL_AWB");
            $NO_BL_AWB = $QueryHeader->get("NO_BL_AWB");
            $TGL_BL_AWB = $QueryHeader->get("TGL_BL_AWB");
            $NO_DO = $QueryHeader->get("NO_DO");
            $TGL_DO = $QueryHeader->get("TGL_DO");
            $TGL_EXPIRED_DO = $QueryHeader->get("TGL_EXPIRED_DO");
			$NAMA_FORWARDER = str_replace("'", '', str_replace('&', '&amp;', $QueryHeader->get("NAMA_FORWARDER")));
			$NPWP_FORWARDER = $QueryHeader->get("NPWP_FORWARDER");
			$ALAMAT_FORWARDER = str_replace("'", '', str_replace('&', '&amp;', $QueryHeader->get("ALAMAT_FORWARDER")));
			$NO_PERMOHONAN_CFS = $QueryHeader->get("NO_PERMOHONAN_CFS");
			$KD_TPS_ASAL = $QueryHeader->get("KD_TPS_ASAL");
			$KD_TPS_TUJUAN = $QueryHeader->get("KD_TPS_TUJUAN");
			$KD_GUDANG_ASAL = $QueryHeader->get("KD_GUDANG_ASAL");
			$KD_GUDANG_TUJUAN = $QueryHeader->get("KD_GUDANG_TUJUAN");
			$NO_BC11 = $QueryHeader->get("NO_BC11");
			$TGL_BC11 = $QueryHeader->get("TGL_BC11");
			$NO_CONT_ASAL = $QueryHeader->get("NO_CONT_ASAL");
			$KD_DOK_INOUT = $QueryHeader->get("KD_DOK_INOUT");
			$NO_DOK = $QueryHeader->get("NO_DOK_INOUT");
			$TGL_DOK = $QueryHeader->get("TGL_DOK_INOUT");
			$CONSIGNEE = str_replace("'", '', str_replace('&', '&amp;', $QueryHeader->get("CONSIGNEE")));
            $NPWP_CONSIGNEE = $QueryHeader->get("NPWP_CONSIGNEE");
            $NM_ANGKUT = $QueryHeader->get("NM_ANGKUT");
            $NO_VOYAGE = $QueryHeader->get("NO_VOYAGE");
            $TGL_TIBA = $QueryHeader->get("TGL_TIBA");
            $JENIS_TRANSAKSI = $QueryHeader->get("JENIS_TRANSAKSI");
            $TGL_KELUAR_LAMA = $QueryHeader->get("TGL_KELUAR_LAMA");
            $NO_POLISI_TRUCK = $QueryHeader->get("NO_POLISI_TRUCK");

            //create xml
            $message = '<?xml version="1.0" encoding="UTF-8"?>';
            $message .= '<DOCUMENT>';
            $message .= '<ORDERPENGELUARANBARANG>';
            $message .= '<HEADER>';
            $message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
            $message .= '<JENIS_BILLING>' . $JENIS_BILLING . '</JENIS_BILLING>';
            $message .= '<JENIS_BAYAR>' . $JENIS_BAYAR . '</JENIS_BAYAR>';
            $message .= '<JENIS_TRANSAKSI>' . $JENIS_TRANSAKSI . '</JENIS_TRANSAKSI>';
            $message .= '<TGL_KELUAR_LAMA>' . $TGL_KELUAR_LAMA . '</TGL_KELUAR_LAMA>';
            $message .= '<TGL_KELUAR>' . $TGL_KELUAR . '</TGL_KELUAR>';
            $message .= '<NO_MASTER_BL_AWB>' . $NO_MASTER_BL_AWB . '</NO_MASTER_BL_AWB>';
            $message .= '<TGL_MASTER_BL_AWB>' . $TGL_MASTER_BL_AWB . '</TGL_MASTER_BL_AWB>';
            $message .= '<NO_BL_AWB>' . $NO_BL_AWB . '</NO_BL_AWB>';
            $message .= '<TGL_BL_AWB>' . $TGL_BL_AWB . '</TGL_BL_AWB>';
            $message .= '<NO_DO>' . $NO_DO . '</NO_DO>';
            $message .= '<TGL_DO>' . $TGL_DO . '</TGL_DO>';
            $message .= '<TGL_EXPIRED_DO>' . $TGL_EXPIRED_DO . '</TGL_EXPIRED_DO>';
            $message .= '<NAMA_FORWARDER>' . $NAMA_FORWARDER . '</NAMA_FORWARDER>';
            $message .= '<NPWP_FORWARDER>' . $NPWP_FORWARDER . '</NPWP_FORWARDER>';
            $message .= '<ALAMAT_FORWARDER>' . $ALAMAT_FORWARDER . '</ALAMAT_FORWARDER>';
            $message .= '<NO_PERMOHONAN_CFS>' . $NO_PERMOHONAN_CFS . '</NO_PERMOHONAN_CFS>';
            $message .= '<KD_TPS_ASAL>' . $NKD_TPS_ASALO_ORDER . '</KD_TPS_ASAL>';
            $message .= '<KD_TPS_TUJUAN>' . $KD_TPS_TUJUAN . '</KD_TPS_TUJUAN>';
            $message .= '<KD_GUDANG_ASAL>' . $KD_GUDANG_ASAL . '</KD_GUDANG_ASAL>';
            $message .= '<KD_GUDANG_TUJUAN>' . $KD_GUDANG_TUJUAN . '</KD_GUDANG_TUJUAN>';
            $message .= '<NO_BC11>' . $NO_BC11 . '</NO_BC11>';
            $message .= '<TGL_BC11>' . $TGL_BC11 . '</TGL_BC11>';
            $message .= '<NO_CONT_ASAL>' . $NO_CONT_ASAL . '</NO_CONT_ASAL>';
            $message .= '<KD_DOK_INOUT>' . $KD_DOK_INOUT . '</KD_DOK_INOUT>';
            $message .= '<NO_DOK>' . $NO_DOK . '</NO_DOK>';
            $message .= '<TGL_DOK>' . $TGL_DOK . '</TGL_DOK>';
            $message .= '<CONSIGNEE>' . $CONSIGNEE . '</CONSIGNEE>';
            $message .= '<NPWP_CONSIGNEE>' . $NPWP_CONSIGNEE . '</NPWP_CONSIGNEE>';
            $message .= '<NM_ANGKUT>' . $NM_ANGKUT . '</NM_ANGKUT>';
            $message .= '<NO_VOYAGE>' . $NO_VOYAGE . '</NO_VOYAGE>';
            $message .= '<TGL_TIBA>' . $TGL_TIBA . '</TGL_TIBA>';
            $message .= '<NO_POLISI_TRUCK>' . $NO_POLISI_TRUCK . '</NO_POLISI_TRUCK>';
            $message .= '</HEADER>';

            $SQLDetilCont = "SELECT A.NO_CONT, A.KD_CONT_UKURAN, A.KD_CONT_JENIS FROM t_order_cont A WHERE A.ID = '" . $ID . "'";
            $QueryDetilCont = $conn->query($SQLDetilCont);

            if ($QueryDetilCont->size() > 0) {
                if ($QueryDetilCont->size() > 1) {
                    $message .= '<DETIL_CONT>';
                    while ($QueryDetilCont->next()) {

                        $NO_CONT = $QueryDetilCont->get("NO_CONT");
                        $KD_UK_CONT = $QueryDetilCont->get("KD_CONT_UKURAN");
                        $message .= '<CONTAINER>';
                        $message .= '<NO_CONT>' . $NO_CONT . '</NO_CONT>';
                        $message .= '<KD_CONT_UKURAN>' . $KD_UK_CONT . '</KD_CONT_UKURAN>';
                        $message .= '</CONTAINER>';
                    }
                    $message .= '</DETIL_CONT>';
                } elseif ($QueryDetilCont->size() == 1) {
                    $QueryDetilCont->next();
                    $NO_CONT = $QueryDetilCont->get("NO_CONT");
                    $KD_UK_CONT = $QueryDetilCont->get("KD_CONT_UKURAN");
                    $message .= '<DETIL_CONT>';
                    $message .= '<CONTAINER>';
                    $message .= '<NO_CONT>' . $NO_CONT . '</NO_CONT>';
                    $message .= '<KD_CONT_UKURAN>' . $KD_UK_CONT . '</KD_CONT_UKURAN>';
                    $message .= '</CONTAINER>';
                    $message .= '</DETIL_CONT>';
                }
            } else {
                $message .= '<DETIL_CONT>';
                $message .= '<CONTAINER>';
                $message .= '<NO_CONT></NO_CONT>';
                $message .= '<KD_CONT_UKURAN></KD_CONT_UKURAN>';
                $message .= '</CONTAINER>';
                $message .= '</DETIL_CONT>';
            }

            $SQLDetilKms = "SELECT A.JNS_KMS, A.MERK_KMS, A.JML_KMS FROM t_order_kms A WHERE A.ID = '" . $ID . "'";
            $QueryDetilKms = $conn->query($SQLDetilKms);
            if ($QueryDetilKms->size() > 0) {
                if ($QueryDetilKms->size() > 1) {
                    $message .= '<DETIL_KMS>';
                    while ($QueryDetilKms->next()) {
                        $JNS_KMS = $QueryDetilKms->get("JNS_KMS");
						$MERK_KMS = str_replace('&', '&amp;', $QueryDetilKms->get("MERK_KMS"));
                        $JML_KMS = $QueryDetilKms->get("JML_KMS");
                        $message .= '<KEMASAN>';
                        $message .= '<JNS_KMS>' . $JNS_KMS . '</JNS_KMS>';
                        $message .= '<MERK_KMS>' . $MERK_KMS . '</MERK_KMS>';
                        $message .= '<JML_KMS>' . $JML_KMS . '</JML_KMS>';
                        $message .= '</KEMASAN>';
                    }
                    $message .= '</DETIL_KMS>';
                } elseif ($QueryDetilKms->size() == 1) {
                    $QueryDetilKms->next();
                    $JNS_KMS = $QueryDetilKms->get("JNS_KMS");
					$MERK_KMS = str_replace('&', '&amp;', $QueryDetilKms->get("MERK_KMS"));
                    $JML_KMS = $QueryDetilKms->get("JML_KMS");
                    $message .= '<DETIL_KMS>';
                    $message .= '<KEMASAN>';
                    $message .= '<JNS_KMS>' . $JNS_KMS . '</JNS_KMS>';
                    $message .= '<MERK_KMS>' . $MERK_KMS . '</MERK_KMS>';
                    $message .= '<JML_KMS>' . $JML_KMS . '</JML_KMS>';
                    $message .= '</KEMASAN>';
                    $message .= '</DETIL_KMS>';
                }
            } else {
                $message .= '<DETIL_KMS>';
                $message .= '<KEMASAN>';
                $message .= '<JNS_KMS></JNS_KMS>';
                $message .= '<MERK_KMS></MERK_KMS>';
                $message .= '<JML_KMS></JML_KMS>';
                $message .= '</KEMASAN>';
                $message .= '</DETIL_KMS>';
            }

            $message .= '</ORDERPENGELUARANBARANG>';
            $message .= '</DOCUMENT>';
        } else {
			$del++;
            $message = '<?xml version="1.0" encoding="UTF-8"?>';
            $message .= '<DOCUMENT>';
            $message .= '<ORDERPENGELUARANBARANG>';
            $message .= '<HEADER>';
            $message .= '<STATUS>FALSE</STATUS>';
            $message .= '<RESPON>Data Tidak Ada</RESPON>';
            $message .= '</HEADER>';
            $message .= '</ORDERPENGELUARANBARANG>';
            $message .= '</DOCUMENT>';
        }
        updateOrderPBarang($ID);
    }


    $return = $message;
    updateLogServices($IDLogServices, $return);
	if($del>0){
		deleteLogServices($IDLogServices);
	}

    $conn->disconnect();
    return $return;
}

function ConfirmTagihanPenimbunan($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://103.29.187.215/cfs-center/TPSServices/sever_plp.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ConfirmTagihanPenimbunan', $fStream);

    $xml = str_replace('&', '', $fStream);
    // echo $xml;die();
    $SQLlogin = "SELECT ID FROM t_organisasi WHERE USERNAME_TPSONLINE_BC = '" . $Username . "'";
    // echo $SQLlogin;die();
    $Query = $conn->query($SQLlogin);
    if ($Query->size() > 0) {
        $Query->next();
        $KD_ORG_SENDER = $Query->get("ID");
    } else {
        $KD_ORG_SENDER = "";
    }
    $STR_DATA = $fStream;


    $SQL = "INSERT INTO mailbox (SNRF, KD_APRF, KD_ORG_SENDER, KD_ORG_RECEIVER,
                        STR_DATA, KD_STATUS, TGL_STATUS)
                VALUES (NULL,'ConfirmTagihanPenimbunan', '" . $KD_ORG_SENDER . "', '1',
                        '" . $STR_DATA . "','100', NOW())";
    // echo $SQL;die();
    // print_r($SQL);die();
    $Execute = $conn->execute($SQL);
    if ($Execute != '') {
        $return = "Proses Berhasil Tersimpan di Portal CFS";
    } else {
        $return = "Proses GAGAL Tersimpan di Portal CFS";
    }
    updateLogServices($IDLogServices, $return);

    $conn->disconnect();
    return $return;
}

function ConfirmTagihanPLP($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ConfirmTagihanPLP', $fStream);

    $xml = str_replace('&', '', $fStream);
    // echo $xml;die();
    $SQLlogin = "SELECT ID FROM t_organisasi WHERE USERNAME_TPSONLINE_BC = '" . $Username . "'";
    // echo $SQLlogin;die();
    $Query = $conn->query($SQLlogin);
    if ($Query->size() > 0) {
        $Query->next();
        $KD_ORG_SENDER = $Query->get("ID");
    } else {
        $KD_ORG_SENDER = "";
    }
    $STR_DATA = $fStream;


    $SQL = "INSERT INTO mailbox (SNRF, KD_APRF, KD_ORG_SENDER, KD_ORG_RECEIVER,
                        STR_DATA, KD_STATUS, TGL_STATUS)
                VALUES (NULL,'ConfirmTagihanPLP', '" . $KD_ORG_SENDER . "', '1',
                        '" . $STR_DATA . "','100', NOW())";
    // echo $SQL;die();
    // print_r($SQL);die();
    $Execute = $conn->execute($SQL);
    if ($Execute != '') {
        $return = "Proses Berhasil Tersimpan di Portal CFS";
    } else {
        $return = "Proses GAGAL Tersimpan di Portal CFS";
    }
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function ValidasiTagihanPenimbunan($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ValidasiTagihanPenimbunan', $fStream);

    $xml = str_replace('&', '', $fStream);
    // echo $xml;die();
    $SQLlogin = "SELECT ID FROM t_organisasi WHERE USERNAME_TPSONLINE_BC = '" . $Username . "'";
    // echo $SQLlogin;die();
    $Query = $conn->query($SQLlogin);
    if ($Query->size() > 0) {
        $Query->next();
        $KD_ORG_SENDER = $Query->get("ID");
    } else {
        $KD_ORG_SENDER = "";
    }
    $STR_DATA = $fStream;


    $SQL = "INSERT INTO mailbox (SNRF, KD_APRF, KD_ORG_SENDER, KD_ORG_RECEIVER,
                        STR_DATA, KD_STATUS, TGL_STATUS)
                VALUES (NULL,'ValidasiTagihanPenimbunan', '" . $KD_ORG_SENDER . "', '1',
                        '" . $STR_DATA . "','100', NOW())";
    // echo $SQL;die();
    // print_r($SQL);die();
    $Execute = $conn->execute($SQL);
    if ($Execute != '') {
        $return = "Proses Berhasil Tersimpan di Portal CFS";
    } else {
        $return = "Proses GAGAL Tersimpan di Portal CFS";
    }
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function ValidasiTagihanPLP($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ValidasiTagihanPLP', $fStream);

    $xml = str_replace('&', '', $fStream);
    // echo $xml;die();
    $SQLlogin = "SELECT ID FROM t_organisasi WHERE USERNAME_TPSONLINE_BC = '" . $Username . "'";
    // echo $SQLlogin;die();
    $Query = $conn->query($SQLlogin);
    if ($Query->size() > 0) {
        $Query->next();
        $KD_ORG_SENDER = $Query->get("ID");
    } else {
        $KD_ORG_SENDER = "";
    }
    $STR_DATA = $fStream;


    $SQL = "INSERT INTO mailbox (SNRF, KD_APRF, KD_ORG_SENDER, KD_ORG_RECEIVER,
                        STR_DATA, KD_STATUS, TGL_STATUS)
                VALUES (NULL,'ValidasiTagihanPLP', '" . $KD_ORG_SENDER . "', '1',
                        '" . $STR_DATA . "','100', NOW())";
    // echo $SQL;die();
    // print_r($SQL);die();
    $Execute = $conn->execute($SQL);
    if ($Execute != '') {
        $return = "Proses Berhasil Tersimpan di Portal CFS";
    } else {
        $return = "Proses GAGAL Tersimpan di Portal CFS";
    }
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function ValidasiEDC($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ValidasiEDC', $fStream);

    $xml = str_replace('&', '', $fStream);
    // echo $xml;die();
    $SQLlogin = "SELECT ID FROM t_organisasi WHERE USERNAME_TPSONLINE_BC = '" . $Username . "'";
    // echo $SQLlogin;die();
    $Query = $conn->query($SQLlogin);
    if ($Query->size() > 0) {
        $Query->next();
        $KD_ORG_SENDER = $Query->get("ID");
    } else {
        $KD_ORG_SENDER = "";
    }
    $STR_DATA = $fStream;


    $SQL = "INSERT INTO mailbox (SNRF, KD_APRF, KD_ORG_SENDER, KD_ORG_RECEIVER,
                        STR_DATA, KD_STATUS, TGL_STATUS)
                VALUES (NULL,'ValidasiEDC', '" . $KD_ORG_SENDER . "', '1',
                        '" . $STR_DATA . "','100', NOW())";
    // echo $SQL;die();
    // print_r($SQL);die();
    $Execute = $conn->execute($SQL);
    if ($Execute != '') {
        $return = "Proses Berhasil Tersimpan di Portal CFS";
    } else {
        $return = "Proses GAGAL Tersimpan di Portal CFS";
    }
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetDataBilling($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'OrderPengeluaranBarang', $fStream);
    $xml = str_replace('&', '', $fStream);
    // echo $xml;die();
    $SQLlogin = "SELECT ID FROM t_organisasi WHERE USERNAME_TPSONLINE_BC = '" . $Username . "'";
    // echo $SQLlogin;die();
    $Query = $conn->query($SQLlogin);
    if ($Query->size() > 0) {
        $Query->next();
        $KD_ORG_SENDER = $Query->get("ID");
    } else {
        $KD_ORG_SENDER = "";
    }
    $STR_DATA = $fStream;
    $xml = xml2ary($STR_DATA);
    if (count($xml) > 0) {
        $xml = $xml['DOCUMENT']['_c'];
        // print_r($xml);die();
        $OrderPB = $xml['TAGIHANEDC']['_c'];
        // print_r($OrderPB);die();
        $NO_ORDER = trim($OrderPB['NO_ORDER']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['NO_ORDER']['_v'])) . "";
        // print_r($KD_GUDANG);die();
        $SQLHeader = "SELECT A.ID, A.JENIS_BILLING, A.NO_ORDER, B.CONSIGNEE, B.NPWP_CONSIGNEE, B.NO_BL_AWB, A.SUBTOTAL, A.PPN, A.TOTAL
                FROM t_billing_cfshdr A INNER JOIN t_order_hdr B ON A.NO_ORDER = B.NO_ORDER
                WHERE A.NO_ORDER = '" . $NO_ORDER . "'";
        $QueryHeader = $conn->query($SQLHeader);

        if ($QueryHeader->size() > 1) {
            $message = '<?xml version="1.0" encoding="UTF-8"?>';
            $message .= '<DOCUMENT>';
            $message .= '<DATA>';
            $message .= '<INVOICE>';
            $message .= '<STATUS>TRUE</STATUS>';
            $message .= '<MESSAGE>SUKSES</MESSAGE>';
            $message .= '<HEADERFIELD>JENIS_BILLING,NO_ORDER,CONSIGNEE,NPWP_CONSIGNEE,NO_BL_AWB,SUBTOTAL,ADMINISTRASI,PPN,TOTAL</HEADERFIELD>';
            $message .= '<DETAILFIELD>NO_CONT,MRK_KMS,DESKRIPSI,QTY,SATUAN,TARIF_DASAR,TOTAL</DETAILFIELD>';
            for ($i = 0; $i < $QueryHeader->size(); $i++) {
                $QueryHeader->next();
                $ID = $QueryHeader->get("ID");
                $JENIS_BILLING = $QueryHeader->get("JENIS_BILLING");
                $NO_ORDER = $QueryHeader->get("NO_ORDER");
                $CONSIGNEE = $QueryHeader->get("CONSIGNEE");
                $NPWP_CONSIGNEE = $QueryHeader->get("NPWP_CONSIGNEE");
                $NO_BL_AWB = $QueryHeader->get("NO_BL_AWB");
                $SUBTOTAL = $QueryHeader->get("SUBTOTAL");
                $ADMINISTRASI = $QueryHeader->get("ADMINISTRASI");
                $PPN = $QueryHeader->get("PPN");
                $TOTAL = $QueryHeader->get("TOTAL");

                $message .= '<HEADER>';
                $message .= '<JENIS_BILLING>' . $JENIS_BILLING . '</JENIS_BILLING>';
                $message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
                $message .= '<CONSIGNEE>' . $CONSIGNEE . '</CONSIGNEE>';
                $message .= '<NPWP_CONSIGNEE>' . $NPWP_CONSIGNEE . '</NPWP_CONSIGNEE>';
                $message .= '<NO_BL_AWB>' . $NO_BL_AWB . '</NO_BL_AWB>';
                $message .= '<SUBTOTAL>' . $SUBTOTAL . '</SUBTOTAL>';
                $message .= '<ADMINISTRASI>' . $ADMINISTRASI . '</ADMINISTRASI>';
                $message .= '<PPN>' . $PPN . '</PPN>';
                $message .= '<TOTAL>' . $TOTAL . '</TOTAL>';
                $message .= '</HEADER>';

                $SQLDetil = "SELECT A.NO_CONT, A.MRK_KMS, B.DESKRIPSI, A.QTY, A.SATUAN, A.TARIF_DASAR, A.TOTAL
                                    FROM t_billing_cfsdtl A INNER JOIN reff_billing_cfs B ON A.KODE_BILL = B.KODE_BILL
                                    WHERE A.ID = '" . $ID . "'";
                $QueryDetil = $conn->query($SQLDetil);
                if ($QueryDetil->size() > 0) {
                    if ($QueryDetil->size() > 1) {
                        for ($i = 0; $i < $QueryDetil->size(); $i++) {
                            $QueryDetil->next();
                            $NO_CONT = $QueryDetil->get("NO_CONT");
                            $MRK_KMS = $QueryDetil->get("MRK_KMS");
                            $DESKRIPSI = $QueryDetil->get("DESKRIPSI");
                            $QTY = $QueryDetil->get("QTY");
                            $SATUAN = $QueryDetil->get("SATUAN");
                            $TARIF_DASAR = $QueryDetil->get("TARIF_DASAR");
                            $TOTAL = $QueryDetil->get("TOTAL");

                            $j = $i + 1;
                            $message .= '<DETAIL' . $j . '>';
                            $message .= '<NO_CONT>' . $NO_CONT . '</NO_CONT>';
                            $message .= '<LINE_NUMBER>' . $j . '</LINE_NUMBER>';
                            $message .= '<MRK_KMS>' . $MRK_KMS . '</MRK_KMS>';
                            $message .= '<DESKRIPSI>' . $DESKRIPSI . '</DESKRIPSI>';
                            $message .= '<QTY>' . $QTY . '</QTY>';
                            $message .= '<SATUAN>' . $SATUAN . '</SATUAN>';
                            $message .= '<TARIF_DASAR>' . $TARIF_DASAR . '</TARIF_DASAR>';
                            $message .= '<TOTAL>' . $TOTAL . '</TOTAL>';
                            $message .= '</DETAIL' . $j . '>';
                        }
                    } elseif ($QueryDetil->size() == 1) {
                        $QueryDetil->next();
                        $NO_CONT = $QueryDetil->get("NO_CONT");
                        $MRK_KMS = $QueryDetil->get("MRK_KMS");
                        $DESKRIPSI = $QueryDetil->get("DESKRIPSI");
                        $QTY = $QueryDetil->get("QTY");
                        $SATUAN = $QueryDetil->get("SATUAN");
                        $TARIF_DASAR = $QueryDetil->get("TARIF_DASAR");
                        $TOTAL = $QueryDetil->get("TOTAL");

                        $message .= '<DETAIL1>';
                        $message .= '<LINE_NUMBER>1</LINE_NUMBER>';
                        $message .= '<NO_CONT>' . $NO_CONT . '</NO_CONT>';
                        $message .= '<MRK_KMS>' . $MRK_KMS . '</MRK_KMS>';
                        $message .= '<DESKRIPSI>' . $DESKRIPSI . '</DESKRIPSI>';
                        $message .= '<QTY>' . $QTY . '</QTY>';
                        $message .= '<SATUAN>' . $SATUAN . '</SATUAN>';
                        $message .= '<TARIF_DASAR>' . $TARIF_DASAR . '</TARIF_DASAR>';
                        $message .= '<TOTAL>' . $TOTAL . '</TOTAL>';
                        $message .= '</DETAIL1>';
                    }
                } else {
                    
                }
            }
            $message .= '</INVOICE>';
            $message .= '</DATA>';
            $message .= '</DOCUMENT>';
        } elseif ($QueryHeader->size() == 1) {
            $message = '<?xml version="1.0" encoding="UTF-8"?>';
            $message .= '<DOCUMENT>';
            $message .= '<DATA>';
            $message .= '<INVOICE>';
            $message .= '<STATUS>TRUE</STATUS>';
            $message .= '<MESSAGE>SUKSES</MESSAGE>';
            $message .= '<HEADERFIELD>JENIS_BILLING,NO_ORDER,CONSIGNEE,NPWP_CONSIGNEE,NO_BL_AWB,SUBTOTAL,ADMINISTRASI,PPN,TOTAL</HEADERFIELD>';
            $message .= '<DETAILFIELD>NO_CONT,MRK_KMS,DESKRIPSI,QTY,SATUAN,TARIF_DASAR,TOTAL</DETAILFIELD>';
            $QueryHeader->next();
            $ID = $QueryHeader->get("ID");
            $JENIS_BILLING = $QueryHeader->get("JENIS_BILLING");
            $NO_ORDER = $QueryHeader->get("NO_ORDER");
            $CONSIGNEE = $QueryHeader->get("CONSIGNEE");
            $NPWP_CONSIGNEE = $QueryHeader->get("NPWP_CONSIGNEE");
            $NO_BL_AWB = $QueryHeader->get("NO_BL_AWB");
            $SUBTOTAL = $QueryHeader->get("SUBTOTAL");
            $ADMINISTRASI = $QueryHeader->get("ADMINISTRASI");
            $PPN = $QueryHeader->get("PPN");
            $TOTAL = $QueryHeader->get("TOTAL");

            $message .= '<HEADER>';

            $message .= '<JENIS_BILLING>' . $JENIS_BILLING . '</JENIS_BILLING>';
            $message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
            $message .= '<CONSIGNEE>' . $CONSIGNEE . '</CONSIGNEE>';
            $message .= '<NPWP_CONSIGNEE>' . $NPWP_CONSIGNEE . '</NPWP_CONSIGNEE>';
            $message .= '<NO_BL_AWB>' . $NO_BL_AWB . '</NO_BL_AWB>';
            $message .= '<SUBTOTAL>' . $SUBTOTAL . '</SUBTOTAL>';
            $message .= '<ADMINISTRASI>' . $ADMINISTRASI . '</ADMINISTRASI>';
            $message .= '<PPN>' . $PPN . '</PPN>';
            $message .= '<TOTAL>' . $TOTAL . '</TOTAL>';
            $message .= '</HEADER>';

            $SQLDetil = "SELECT A.NO_CONT, A.MRK_KMS, B.DESKRIPSI, A.QTY, A.SATUAN, A.TARIF_DASAR, A.TOTAL
                                FROM t_billing_cfsdtl A INNER JOIN reff_billing_cfs B ON A.KODE_BILL = B.KODE_BILL
                                WHERE A.ID = '" . $ID . "'";
            $QueryDetil = $conn->query($SQLDetil);
            if ($QueryDetil->size() > 0) {
                if ($QueryDetil->size() > 1) {
                    for ($i = 0; $i < $QueryDetil->size(); $i++) {
                        $QueryDetil->next();
                        $NO_CONT = $QueryDetil->get("NO_CONT");
                        $MRK_KMS = $QueryDetil->get("MRK_KMS");
                        $DESKRIPSI = $QueryDetil->get("DESKRIPSI");
                        $QTY = $QueryDetil->get("QTY");
                        $SATUAN = $QueryDetil->get("SATUAN");
                        $TARIF_DASAR = $QueryDetil->get("TARIF_DASAR");
                        $TOTAL = $QueryDetil->get("TOTAL");

                        $j = $i + 1;
                        $message .= '<DETAIL' . $j . '>';
                        $message .= '<LINE_NUMBER>' . $j . '</LINE_NUMBER>';
                        $message .= '<NO_CONT>' . $NO_CONT . '</NO_CONT>';
                        $message .= '<MRK_KMS>' . $MRK_KMS . '</MRK_KMS>';
                        $message .= '<DESKRIPSI>' . $DESKRIPSI . '</DESKRIPSI>';
                        $message .= '<QTY>' . $QTY . '</QTY>';
                        $message .= '<SATUAN>' . $SATUAN . '</SATUAN>';
                        $message .= '<TARIF_DASAR>' . $TARIF_DASAR . '</TARIF_DASAR>';
                        $message .= '<TOTAL>' . $TOTAL . '</TOTAL>';
                        $message .= '</DETAIL' . $j . '>';
                    }
                } elseif ($QueryDetil->size() == 1) {
                    $QueryDetil->next();
                    $NO_CONT = $QueryDetil->get("NO_CONT");
                    $MRK_KMS = $QueryDetil->get("MRK_KMS");
                    $DESKRIPSI = $QueryDetil->get("DESKRIPSI");
                    $QTY = $QueryDetil->get("QTY");
                    $SATUAN = $QueryDetil->get("SATUAN");
                    $TARIF_DASAR = $QueryDetil->get("TARIF_DASAR");
                    $TOTAL = $QueryDetil->get("TOTAL");

                    $message .= '<DETAIL1>';
                    $message .= '<LINE_NUMBER>1</LINE_NUMBER>';
                    $message .= '<NO_CONT>' . $NO_CONT . '</NO_CONT>';
                    $message .= '<MRK_KMS>' . $MRK_KMS . '</MRK_KMS>';
                    $message .= '<DESKRIPSI>' . $DESKRIPSI . '</DESKRIPSI>';
                    $message .= '<QTY>' . $QTY . '</QTY>';
                    $message .= '<SATUAN>' . $SATUAN . '</SATUAN>';
                    $message .= '<TARIF_DASAR>' . $TARIF_DASAR . '</TARIF_DASAR>';
                    $message .= '<TOTAL>' . $TOTAL . '</TOTAL>';
                    $message .= '</DETAIL1>';
                }
            } else {
                
            }
            $message .= '</INVOICE>';
            $message .= '</DATA>';
            $message .= '</DOCUMENT>';
        } else {
            $message = '<?xml version="1.0" encoding="UTF-8"?>';
            $message .= '<DOCUMENT>';
            $message .= '<DATA>';
            $message .= '<INVOICE>';
            $message .= '<STATUS>FALSE</STATUS>';
            $message .= '<MESSAGE>' . $SQLHeader . '</MESSAGE>';
            $message .= '</INVOICE>';
            $message .= '</DATA>';
            $message .= '</DOCUMENT>';
        }
    }


    $return = $message;
    updateLogServices($IDLogServices, $return);

    $conn->disconnect();
    return $return;
}

function GetPermohonanCFS($string, $string0) {

    global $CONF, $conn;
    $conn->connect();
    $username = $string;
    $password = $string0;
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices($username, $password, $WSDLSOAP, 'GetPermohonanCFS', 'XML');

    $SQLUSER = "SELECT B.KD_TPS, B.KD_GUDANG
                FROM  t_organisasi B 
                WHERE B.USERNAME_TPSONLINE_BC = '" . $username . "'
                      AND B.PASSWORD_TPSONLINE_BC = '" . $password . "'";
    $QueryUser = $conn->query($SQLUSER);

    if ($QueryUser->size() == 0) {
        $message = '<?xml version="1.0" encoding="UTF-8"?>';
        $message .= '<DOCUMENT>';
        $message .= '<LOADPERMOHONANCFS>USERNAME ATAU PASSWORD SALAH.</LOADPERMOHONANCFS>';
        $message .= '</DOCUMENT>';
        $return = $message;

        $logServices = updateLogServices($IDLogServices, $return);
    } else {
        $QueryUser->next();
        $KD_TPS = $QueryUser->get("KD_TPS");
        $KD_GUDANG = $QueryUser->get("KD_GUDANG");

        $SQLHEADER = "SELECT A.ID,A.NO_PERMOHONAN_CFS, A.KD_TPS_ASAL, A.KD_TPS_TUJUAN, A.KD_GUDANG_ASAL, A.KD_GUDANG_TUJUAN,
            B.NM_LENGKAP,B.KD_ORGANISASI,C.NAMA,C.ALAMAT,C.EMAIL,C.NPWP,C.NOTELP,
            C.NOFAX,A.NAMA_KAPAL,A.CALL_SIGN,A.NO_VOY_FLIGHT,A.TGL_TIBA,A.NO_BC11,
            A.TGL_BC11, A.TGL_PERMOHONAN_CFS 
            FROM t_permohonan_cfshdr A INNER JOIN app_user B ON A.ID_USER=B.ID INNER JOIN t_organisasi C ON B.KD_ORGANISASI=C.ID
            WHERE A.KD_STATUS='200' AND A.KD_GUDANG_ASAL='" . $KD_GUDANG . "' AND A.KD_TPS_ASAL = '" . $KD_TPS . "'";

        $QueryHeader = $conn->query($SQLHEADER);
        if ($QueryHeader->size() > 0) {
            while ($QueryHeader->next()) {
                $message = '<?xml version="1.0" encoding="UTF-8"?>';
                $message .= '<DOCUMENT>';
                $message .= '<LOADPERMOHONANCFS>';
                $message .= '<HEADER>';
                $message .= '<NO_PERMOHONAN_CFS>' . $QueryHeader->get("NO_PERMOHONAN_CFS") . '</NO_PERMOHONAN_CFS>';
                $message .= '<TGL_PERMOHONAN_CFS>' . $QueryHeader->get("TGL_PERMOHONAN_CFS") . '</TGL_PERMOHONAN_CFS>';
                $message .= '<KD_TPS_ASAL>' . $QueryHeader->get("KD_TPS_ASAL") . '</KD_TPS_ASAL>';
                $message .= '<KD_TPS_TUJUAN>' . $QueryHeader->get("KD_TPS_TUJUAN") . '</KD_TPS_TUJUAN>';
                $message .= '<KD_GUDANG_ASAL>' . $QueryHeader->get("KD_GUDANG_ASAL") . '</KD_GUDANG_ASAL>';
                $message .= '<KD_GUDANG_TUJUAN>' . $QueryHeader->get("KD_GUDANG_TUJUAN") . '</KD_GUDANG_TUJUAN>';
                $message .= '<NM_LENGKAP>' . $QueryHeader->get("NM_LENGKAP") . '</NM_LENGKAP>';
                $message .= '<NAMA_ORGANISASI>' . $QueryHeader->get("NAMA_ORGANISASI") . '</NAMA_ORGANISASI>';
                $message .= '<EMAIL>' . $QueryHeader->get("EMAIL") . '</EMAIL>';
                $message .= '<NPWP>' . $QueryHeader->get("NPWP") . '</NPWP>';
                $message .= '<NOTELP>' . $QueryHeader->get("NOTELP") . '</NOTELP>';
                $message .= '<NOFAX>' . $QueryHeader->get("NOFAX") . '</NOFAX>';
                $message .= '<NAMA_KAPAL>' . $QueryHeader->get("NAMA_KAPAL") . '</NAMA_KAPAL>';
                $message .= '<CALL_SIGN>' . $QueryHeader->get("CALL_SIGN") . '</CALL_SIGN>';
                $message .= '<NO_VOY_FLIGHT>' . $QueryHeader->get("NO_VOY_FLIGHT") . '</NO_VOY_FLIGHT>';
                $message .= '<TGL_TIBA>' . $QueryHeader->get("TGL_TIBA") . '</TGL_TIBA>';
                $message .= '<NO_BC11>' . $QueryHeader->get("NO_BC11") . '</NO_BC11>';
                $message .= '<TGL_BC11>' . $QueryHeader->get("TGL_BC11") . '</TGL_BC11>';
                $message .= '</HEADER>';
                $message .= '<DETAIL>';

                $SQLKONTAINER = "SELECT NO_CONT,KD_CONT_UKURAN,WK_REKAM FROM t_permohonan_cfsdtl WHERE ID='" . $QueryHeader->get("ID") . "'";
                $QueryKontainer = $conn->query($SQLKONTAINER);
                while ($QueryKontainer->next()) {
                    $message .= '<CONT>';
                    $message .= '<NO_CONT>' . $QueryKontainer->get("NO_CONT") . '</NO_CONT>';
                    $message .= '<KD_CONT_UKURAN>' . $QueryKontainer->get("KD_CONT_UKURAN") . '</KD_CONT_UKURAN>';
                    $message .= '<WK_REKAM>' . $QueryKontainer->get("WK_REKAM") . '</WK_REKAM>';
                    $message .= '</CONT>';
                }
                $message .= '<FILE_DOKUMEN>';
                $SQLFILE = "SELECT FILE_DOKUMEN,JNS_FILE_DOKUMEN from t_permohonan_cfsfile WHERE ID='" . $QueryHeader->get("ID") . "'";
                $QueryFILE = $conn->query($SQLFILE);
                while ($QueryFILE->next()) {
                    $message .= '<URL>';
                    $message .= '<LINK>http://ipccfscenter.com/upload_cfs/permohonanCFS/' . $QueryFILE->get("FILE_DOKUMEN") . '</LINK>';
                    $message .= '<JNS_FILE>' . $QueryFILE->get("JNS_FILE_DOKUMEN") . '</JNS_FILE>';
                    $message .= '</URL>';
                }
                $message .= '</FILE_DOKUMEN>';
                $message .= '</DETAIL>';
                $message .= '</LOADPERMOHONANCFS>';
                $message .= '</DOCUMENT>';
                $SQL = "UPDATE t_permohonan_cfshdr SET KD_STATUS = '300', WK_REKAM = NOW() WHERE NO_PERMOHONAN_CFS = '" . $QueryHeader->get("NO_PERMOHONAN_CFS") . "'";
                $Execute = $conn->execute($SQL);
            }
            $return = $message;
        } else {
            $message = '<?xml version="1.0" encoding="UTF-8"?>';
            $message .= '<DOCUMENT>';
            $message .= '<LOADPERMOHONANCFS>DATA TIDAK ADA.</LOADPERMOHONANCFS>';
            $message .= '</DOCUMENT>';
            $return = $message;
            $logServices = updateLogServices($IDLogServices, $return);
        }
    }

    $xmlRequest = $message != '' ? $SQLFILE : $return;
    $remarks = 'DATA BERHASIL DIKIRIM';
    updateLogServices($IDLogServices, $return);

    $conn->disconnect();
    return $return;
}

function WSBillingGudang($username, $password, $kdgudang) {

    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices($username, $password, $WSDLSOAP, 'WSBillingGudang', $kdgudang);

    $SQLUSER = "SELECT KD_GUDANG FROM  t_organisasi WHERE USERNAME_TPSONLINE_BC = '" . $username . "'
                AND PASSWORD_TPSONLINE_BC = '" . $password . "'LIMIT 1";
    $QueryUser = $conn->query($SQLUSER);

    $del=0;
    if ($QueryUser->size() == 0) {
        $message = '<?xml version="1.0" encoding="UTF-8"?>';
        $message .= '<DOCUMENT>';
        $message .= '<WSBILLINGGUDANG>USERNAME ATAU PASSWORD SALAH.</WSBILLINGGUDANG>';
        $message .= '</DOCUMENT>';
    } else {
        $QueryUser->next();
        $GUDANG=$QueryUser->get("KD_GUDANG");
        if ($GUDANG == $kdgudang) {
            $SQLHEADER = "SELECT A.NO_ORDER,A.NO_BL_AWB,C.TGL_TERIMA,C.NO_INVOICE,B.PPN,B.TOTAL,B.ID FROM t_order_hdr A
            LEFT JOIN t_billing_cfshdr B ON A.NO_ORDER=B.NO_ORDER AND B.FLAG_APPROVE='Y'
            AND B.KD_ALASAN_BILLING='ACCEPT' AND B.STATUS_BAYAR='SETTLED' AND B.IS_VOID IS NULL
            LEFT JOIN t_edc_payment_bank C ON B.NO_INVOICE=C.NO_INVOICE AND C.IS_VOID IS NULL
            WHERE A.KD_STATUS='700' AND A.KD_GUDANG_TUJUAN='".$GUDANG."' AND B.IS_SENDSIMKEU='300'
            ORDER BY C.TGL_TERIMA LIMIT 5";

            $QueryHeader = $conn->query($SQLHEADER);
            if ($QueryHeader->size() > 0) {
                $message = '<?xml version="1.0" encoding="UTF-8"?>';
                $message .= '<DOCUMENT>';
                while ($QueryHeader->next()) {
                    $message .= '<WSBILLINGGUDANG>';
                    $message .= '<HEADER>';
                    $message .= '<Order_Number>' . $QueryHeader->get("NO_ORDER") . '</Order_Number>';
                    $message .= '<BL_Number>' . $QueryHeader->get("NO_BL_AWB") . '</BL_Number>';
                    $message .= '<Payment_Date>' . $QueryHeader->get("TGL_TERIMA") . '</Payment_Date>';
                    $message .= '<Invoice_Number>' . $QueryHeader->get("NO_INVOICE") . '</Invoice_Number>';
                    $message .= '<PPn_amount>' . $QueryHeader->get("PPN") . '</PPn_amount>';
                    $message .= '<Total_amount>' . $QueryHeader->get("TOTAL") . '</Total_amount>';
                    $message .= '</HEADER>';
                    $message .= '<DETAIL>';

                    $SQLKONTAINER = "SELECT KODE_BILL,QTY,TARIF_DASAR,TOTAL
                    FROM t_billing_cfsdtl WHERE ID='" . $QueryHeader->get("ID") . "'";
                    $QueryKontainer = $conn->query($SQLKONTAINER);
                    while ($QueryKontainer->next()) {
                        $message .= '<KMS>';
                        $message .= '<Order_Number>' . $QueryHeader->get("NO_ORDER") . '</Order_Number>';
                        $message .= '<Item>' . $QueryKontainer->get("KODE_BILL") . '</Item>';
                        $message .= '<Qty>' . $QueryKontainer->get("QTY") . '</Qty>';
                        $message .= '<Tarif>' . $QueryKontainer->get("TARIF_DASAR") . '</Tarif>';
                        $message .= '<Jumlah>' . $QueryKontainer->get("TOTAL") . '</Jumlah>';
                        $message .= '</KMS>';
                    }
                    $message .= '</DETAIL>';
                    $message .= '</WSBILLINGGUDANG>';
                    $SQL = "UPDATE t_billing_cfshdr SET FL_SEND = '300' WHERE ID = '" . $QueryHeader->get("ID") . "'";
                    $Execute = $conn->execute($SQL);
                }
                $message .= '</DOCUMENT>';
            } else {
                $message = '<?xml version="1.0" encoding="UTF-8"?>';
                $message .= '<DOCUMENT>';
                $message .= '<WSBILLINGGUDANG>DATA TIDAK ADA.</WSBILLINGGUDANG>';
                $message .= '</DOCUMENT>';
                $del=1;
            }
        } else {
            $message = '<?xml version="1.0" encoding="UTF-8"?>';
            $message .= '<DOCUMENT>';
            $message .= '<WSBILLINGGUDANG>KODE GUDANG TIDAK DITEMUKAN.</WSBILLINGGUDANG>';
            $message .= '</DOCUMENT>';
        }
    }

    $return = $message;
    if($del>0)
      deleteLogServices($IDLogServices);
    else
      updateLogServices($IDLogServices, $return);

    $conn->disconnect();
    return $return;
}

function cek_go_live($user) {
    global $CONF, $conn;
    $SQL = "SELECT a.GO_LIVE FROM t_organisasi a WHERE a.USERNAME_TPSONLINE_BC = '" . trim($user) . "' ";
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) {
        $Query->next();
        if ($Query->get("GO_LIVE") == 'N') {
            return "T";
        } else {
            return "Y";
        }
    } else {
        return "T";
    }
}

function insertLogServices($userName, $Password, $url, $method, $xmlRequest = '', $xmlResponse = '') {
    global $CONF, $conn;
    $ipAddress = getIP();
    $userName = $userName == '' ? 'NULL' : "'" . mysql_real_escape_string($userName) . "'";
    $Password = $Password == '' ? 'NULL' : "'" . mysql_real_escape_string($Password) . "'";
    $url = $url == '' ? 'NULL' : "'" . mysql_real_escape_string($url) . "'";
    $method = $method == '' ? 'NULL' : "'" . mysql_real_escape_string($method) . "'";
    $xmlRequest = $xmlRequest == '' ? 'NULL' : "'" . mysql_real_escape_string($xmlRequest) . "'";
    $xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . mysql_real_escape_string($xmlResponse) . "'";
    $SQL = "INSERT INTO app_log_services (USERNAME, PASSWORD, URL, METHOD, REQUEST, RESPONSE, IP_ADDRESS, WK_REKAM)
            VALUES (" . $userName . ", " . $Password . ", " . $url . ", " . $method . ", " . $xmlRequest . ", " . $xmlResponse . ", '" . $ipAddress . "', NOW())";

    $Execute = $conn->execute($SQL);
    $ID = mysql_insert_id();
    return $ID;
}

function updateLogServices($ID, $xmlResponse = '') {
    global $CONF, $conn;
    $xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . mysql_real_escape_string($xmlResponse) . "'";
    $SQL = "UPDATE app_log_services SET RESPONSE = " . $xmlResponse . "
            WHERE ID = '" . $ID . "'";
    $Execute = $conn->execute($SQL);
}

function updateLogServicesToFailed($ID,$error = '') {
    global $CONF, $conn;
    $error = $error == '' ? 'NULL' : "'" . mysql_real_escape_string($error) . "'";
	$SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID . "'";
	$Execute = $conn->execute($SQL);

 	$SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID . "'";
	$Execute = $conn->execute($SQL);

	$SQL = "UPDATE app_log_services_failed SET KETERANGAN = " . $error . " WHERE ID = '" . $ID . "'";
	$Execute = $conn->execute($SQL);

	if($Execute){
		$SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID . "'";
		$Execute = $conn->execute($SQL);
	}
}

function updateLogServicesToSuccess($ID) {
    global $CONF, $conn;
	$SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID . "'";
	$Execute = $conn->execute($SQL);

	$SQL = "INSERT INTO app_log_services_success SELECT * FROM app_log_services WHERE ID = '" . $ID . "'";
	$Execute = $conn->execute($SQL);

	if($Execute){
		$SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID . "'";
		$Execute = $conn->execute($SQL);                    
	}
}

function deleteLogServices($ID) {
    global $CONF, $conn;
	$SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID . "'";
	$Execute = $conn->execute($SQL);
}

function updateOrderPBarang($ID) {
    global $CONF, $conn;
    $SQL = "UPDATE t_order_hdr A SET A.KD_STATUS = '300' WHERE ID = '" . $ID . "'";
    $Execute = $conn->execute($SQL);
}

function insertLogServicesTest($userName, $Password, $url, $method, $xmlRequest = '', $xmlResponse = '') {
    global $CONF, $conn;
    $ipAddress = getIP();
    $userName = $userName == '' ? 'NULL' : "'" . $userName . "'";
    $Password = $Password == '' ? 'NULL' : "'" . $Password . "'";
    $url = $url == '' ? 'NULL' : "'" . $url . "'";
    $method = $method == '' ? 'NULL' : "'" . $method . "'";
    $xmlRequest = $xmlRequest == '' ? 'NULL' : "'" . $xmlRequest . "'";
    $xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . $xmlResponse . "'";
    $SQL = "INSERT INTO app_log_services_test_cfs (USERNAME, PASSWORD, URL, METHOD, REQUEST, RESPONSE, IP_ADDRESS, WK_REKAM)
            VALUES (" . $userName . ", " . $Password . ", " . $url . ", " . $method . ", " . $xmlRequest . ", " . $xmlResponse . ", '" . $ipAddress . "', NOW())";
    $Execute = $conn->execute($SQL);
    $ID = mysql_insert_id();
    return $ID;
}

function updateLogServicesTest($ID, $xmlResponse = '') {
    global $CONF, $conn;
    $xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . $xmlResponse . "'";
    $SQL = "UPDATE app_log_services_test_cfs SET RESPONSE = " . $xmlResponse . "
            WHERE ID = '" . $ID . "'";
    $Execute = $conn->execute($SQL);
}

function getIP($type = 0) {
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER['REMOTE_ADDR'];
    else {
        $ip = "unknown";
        return $ip;
    }
    if ($type == 1) {
        return md5($ip);
    }
    if ($type == 0) {
        return $ip;
    }
}

function SendCurl($xml, $url, $SOAPAction, $proxy = "", $port = "443") {
    $header[] = 'Content-Type: text/xml';
    $header[] = 'SOAPAction: "' . $SOAPAction . '"';
    $header[] = 'Content-length: ' . strlen($xml);
    $header[] = 'Connection: close';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_PORT, $port);
    //curl_setopt($ch, CURLOPT_PROXY, $proxy);
    //curl_setopt($ch, CURLOPT_VERBOSE, 0);
    //curl_setopt($ch, CURLOPT_HEADER, 0);
    //curl_setopt($ch, CURLOPT_SSLVERSION, 3);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    //curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    $response = curl_exec($ch);
    if (!curl_errno($ch)) {
        $return['return'] = TRUE;
        $return['info'] = curl_getinfo($ch);
        $return['response'] = $response;
    } else {
        $return['return'] = FALSE;
        $return['info'] = curl_error($ch);
        $return['response'] = '';
    }
    return $return;
}

function checkUser($user, $password, $IDLogServices) {
    global $CONF, $conn;
    $SQL = "SELECT B.KD_TIPE_ORGANISASI,B.ID
            FROM app_user_ws A INNER JOIN t_organisasi B ON A.KD_ORGANISASI = B.ID
            WHERE A.USERLOGIN = '" . trim($user) . "'
                  AND A.PASSWORD = '" . trim($password) . "'";
    $Query = $conn->query($SQL);
    if ($Query->size() == 0) {
        $return['return'] = false;
        $return['message'] = 'USERNAME ATAU PASSWORD SALAH.';
        $logServices = updateLogServices($IDLogServices, $return['message']);
    } else {
        $Query->next();
        $return['return'] = true;
        $return['kdorganisasi'] = $Query->get("ID");
    }
    return $return;
}

function InsertBilling($LOADBILLINGHEADER, $countTarif, $countBilling) {
    // echo "sini";die();
    global $CONF, $conn;
    $conn->connect();
    $header = $LOADBILLING['HEADER']['_c'];
    $detil = $LOADBILLING['DETIL']['_c'];

    // print_r($countBilling);die();
    //header
    // $NO_ORDER = trim($loadBillingHeaderxml['NO_ORDER']['_v']) == "" ? "NULL" : "" . strtoupper(trim($loadBillingHeaderxml['NO_ORDER']['_v'])) . "";
    $JENIS_BILLING = trim($LOADBILLINGHEADER['JENIS_BILLING']['_v']) == "" ? "NULL" : "" . strtoupper(trim($LOADBILLINGHEADER['JENIS_BILLING']['_v'])) . "";
    $NO_ORDER = trim($LOADBILLINGHEADER['NO_ORDER']['_v']) == "" ? "NULL" : "" . strtoupper(trim($LOADBILLINGHEADER['NO_ORDER']['_v'])) . "";
    $SUBTOTAL = trim($LOADBILLINGHEADER['SUB_TOTAL']['_v']) == "" ? "NULL" : "" . strtoupper(trim($LOADBILLINGHEADER['SUB_TOTAL']['_v'])) . "";
    $PPN = trim($LOADBILLINGHEADER['PPN']['_v']) == "" ? "NULL" : "" . strtoupper(trim($LOADBILLINGHEADER['PPN']['_v'])) . "";
    $TOTAL = trim($LOADBILLINGHEADER['TOTAL']['_v']) == "" ? "NULL" : "" . strtoupper(trim($LOADBILLINGHEADER['TOTAL']['_v'])) . "";
    $JENIS_BAYAR = trim($LOADBILLINGHEADER['JENIS_BAYAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($LOADBILLINGHEADER['JENIS_BAYAR']['_v'])) . "";
    // $ADMINISTRASI = trim($LOADBILLINGHEADER['ADMINISTRASI']['_v']) == "" ? "NULL" : "" . strtoupper(trim($LOADBILLINGHEADER['ADMINISTRASI']['_v'])) . "";

    if ($JENIS_BILLING == 1) {
        $kodetrx = "02";
    } elseif ($JENIS_BILLING == 2) {
        $kodetrx = "01";
    }
    $kdtglpro = date('Ymd');

    $SQLselectidbef = "SELECT substr(A.NO_PROFORMA_INVOICE, 12) AS NO_PROFORMA_INVOICE FROM t_billing_cfshdr A WHERE A.ID = (SELECT MAX(A.ID) FROM t_billing_cfshdr A) LIMIT 1";
    $Queryselectidbef = $conn->query($SQLselectidbef);
    $Queryselectidbef->next();
    $probef = $Queryselectidbef->get("NO_PROFORMA_INVOICE");
    $pronew = $probef + 1;

    if ($pronew <= 9) {
        $pro = '0000';
    } elseif (99 >= $pronew && $pronew > 9) {
        $pro = '000';
    } elseif (999 >= $pronew && $pronew > 99) {
        $pro = '00';
    } elseif (9999 >= $pronew && $pronew > 999) {
        $pro = '0';
    } elseif (99999 >= $pronew && $pronew > 9999) {
        $pro = '';
    }
    $prourut = $pro . $pronew;

    $NO_PROFORMA = $kodetrx . "-" . $kdtglpro . $prourut;

    //insert t_billing_cfshdr
    $SQLHeader = "INSERT INTO t_billing_cfshdr(JENIS_BILLING,NO_ORDER,TGL_UPDATE,SUBTOTAL,PPN,TOTAL,FLAG_APPROVE,KD_ALASAN_BILLING,JENIS_BAYAR,NO_PROFORMA_INVOICE) VALUES('" . $JENIS_BILLING . "','" . $NO_ORDER . "',
    	NOW(),'" . $SUBTOTAL . "','" . $PPN . "','" . $TOTAL . "','Y','REJECT','" . $JENIS_BAYAR . "','" . $NO_PROFORMA . "')";
    // print_r($SQLHeader);die();
    // print_r($countBilling);die();
    $Execute = $conn->execute($SQLHeader);

    //detail
    $IDHeader = mysql_insert_id();
    // print_r($IDHeader);die();
    return $IDHeader;
}

function InsertBillingDetail($detil, $LOADBILLINGHEADER, $countTarif, $RES, $countBilling, $IDBillingHdr, $JENIS_BILLING) {
    // echo "sini";die();
    global $CONF, $conn;
    $conn->connect();
    $header = $LOADBILLING['HEADER']['_c'];
    // $detil = $xml['DETIL']['_c'];
    //$SQLID = "SELECT A.ID FROM t_billing_cfshdr A WHERE A.NO_ORDER = '" . $NO_ORDER . "'";
    //$Query = $conn->query($SQLID);
    //$Query->next();
    // print_r($IDBillingHdr);die();
    $IDHeader = $IDBillingHdr;
    // print_r($countTarif);die();
    if ($countTarif > 1) {
        for ($i = 0; $i < $countTarif; $i++) {
            $TARIF_DASAR = trim($detil['TARIF'][$i]['_c']['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['TARIF_DASAR']['_v'])) . "";
            $KODE = trim($detil['TARIF'][$i]['_c']['KODE_TARIF']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['KODE_TARIF']['_v'])) . "";
            $QTY = trim($detil['TARIF'][$i]['_c']['QTY']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['QTY']['_v'])) . "";
            $SATUAN = trim($detil['TARIF'][$i]['_c']['SATUAN']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['SATUAN']['_v'])) . "";
            $NILAI = trim($detil['TARIF'][$i]['_c']['NILAI']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['NILAI']['_v'])) . "";
            $HARI = trim($detil['TARIF'][$i]['_c']['HARI']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['TARIF'][$i]['_c']['HARI']['_v'])) . "'";
            $NO_CONT = trim($detil['NO_CONT']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['NO_CONT']['_v'])) . "";
            $UK_CONT = trim($detil['UK_CONT']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['UK_CONT']['_v'])) . "";
            $JNS_KMS = trim($detil['JNS_KMS']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['JNS_KMS']['_v'])) . "";
            $MERK_KMS = trim($detil['MERK_KMS']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['MERK_KMS']['_v'])) . "";
            $JML_KMS = trim($detil['JML_KMS']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['JML_KMS']['_v'])) . "";
            $WEIGHT = trim($detil['WEIGHT']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['WEIGHT']['_v'])) . "";
            $MEASURE = trim($detil['MEASURE']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['MEASURE']['_v'])) . "";
            //insert t_billing_cfsdtl
            if ($JENIS_BILLING == 1) {
                $SQLDetil = "INSERT INTO t_billing_cfsdtl(ID,KODE_BILL,NO_CONT,KD_UK_CONT,TARIF_DASAR,TOTAL,QTY,SATUAN,WEIGHT,MEASURE,HARI) VALUES('" . $IDHeader . "','" . $KODE . "',
                    '" . $NO_CONT . "','" . $UK_CONT . "','" . $TARIF_DASAR . "','" . $NILAI . "','" . $QTY . "','" . $SATUAN . "','" . $WEIGHT . "','" . $MEASURE . "'," . $HARI . ")";
                // print_r($SQLDetil);die();
                $Execute = $conn->execute($SQLDetil);
            } elseif ($JENIS_BILLING == 2) {
                $SQLDetil = "INSERT INTO t_billing_cfsdtl(ID,KODE_BILL,JNS_KMS,MRK_KMS,JML_KMS,TARIF_DASAR,TOTAL,QTY,SATUAN,WEIGHT,MEASURE,HARI) VALUES('" . $IDHeader . "','" . $KODE . "',
                    '" . $JNS_KMS . "','" . $MERK_KMS . "','" . $JML_KMS . "','" . $TARIF_DASAR . "','" . $NILAI . "','" . $QTY . "','" . $SATUAN . "','" . $WEIGHT . "','" . $MEASURE . "'," . $HARI . ")";
                // print_r($SQLDetil . "<br>");
                $Execute = $conn->execute($SQLDetil);
            }
        }
    } elseif ($countTarif == 1) {
        $TARIF_DASAR = trim($detil['TARIF']['_c']['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['TARIF_DASAR']['_v'])) . "";
        $KODE = trim($detil['TARIF']['_c']['KODE_TARIF']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['KODE_TARIF']['_v'])) . "";
        $QTY = trim($detil['TARIF']['_c']['QTY']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['QTY']['_v'])) . "";
        $SATUAN = trim($detil['TARIF']['_c']['SATUAN']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['SATUAN']['_v'])) . "";
        $NILAI = trim($detil['TARIF']['_c']['NILAI']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['NILAI']['_v'])) . "";
        $HARI = trim($detil['TARIF']['_c']['HARI']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['HARI']['_v'])) . "";
        // print_r($HARI);die();
        $NO_CONT = trim($detil['NO_CONT']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['NO_CONT']['_v'])) . "";
        $UK_CONT = trim($detil['UK_CONT']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['UK_CONT']['_v'])) . "";
        $JNS_KMS = trim($detil['JNS_KMS']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['JNS_KMS']['_v'])) . "";
        // $HARI = trim($tarif['HARI']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($tarif['HARI']['_v'])) . "'";
        $MERK_KMS = trim($detil['MERK_KMS']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['MERK_KMS']['_v'])) . "";
        $JML_KMS = trim($detil['JML_KMS']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['JML_KMS']['_v'])) . "";
        $WEIGHT = trim($detil['WEIGHT']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['WEIGHT']['_v'])) . "";
        $MEASURE = trim($detil['MEASURE']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['MEASURE']['_v'])) . "";
        //insert t_billing_cfsdtl
        if ($JENIS_BILLING == 1) {
            $SQLDetil = "INSERT INTO t_billing_cfsdtl(ID,KODE_BILL,NO_CONT,KD_UK_CONT,TARIF_DASAR,TOTAL,QTY,SATUAN,WEIGHT,MEASURE,HARI) VALUES('" . $IDHeader . "','" . $KODE . "',
                '" . $NO_CONT . "','" . $UK_CONT . "','" . $TARIF_DASAR . "','" . $NILAI . "','" . $QTY . "','" . $SATUAN . "','" . $WEIGHT . "','" . $MEASURE . "','" . $HARI . "')";
            // print_r($SQLDetil . "<br>");
            $Execute = $conn->execute($SQLDetil);
        } elseif ($JENIS_BILLING == 2) {
            $SQLDetil = "INSERT INTO t_billing_cfsdtl(ID,KODE_BILL,JNS_KMS,MRK_KMS,JML_KMS,TARIF_DASAR,TOTAL,QTY,SATUAN,WEIGHT,MEASURE,HARI) VALUES('" . $IDHeader . "','" . $KODE . "',
                '" . $JNS_KMS . "','" . $MERK_KMS . "','" . $JML_KMS . "','" . $TARIF_DASAR . "','" . $NILAI . "','" . $QTY . "','" . $SATUAN . "','" . $WEIGHT . "','" . $MEASURE . "','" . $HARI . "')";
            // print_r($SQLDetil . "<br>");die();
            $Execute = $conn->execute($SQLDetil);
        }
    }
}

function insertorder($billing, $ID_LOG) {
    global $CONF, $conn;
    $sqlerror = '';
    $message = "";
    $header = $billing['HEADER']['_c'];
    $detil = $billing['DETIL']['_c'];

    /* Begin Generate data header */

    $NO_ORDER = trim($header['NO_ORDER']['_v']) == "" ? "NULL" : "" . strtoupper(trim($header['NO_ORDER']['_v'])) . "";
    $JENIS_TRANSAKSI = trim($header['JENIS_TRANSAKSI']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['JENIS_TRANSAKSI']['_v'])) . "'";
    $JENIS_BILLING = trim($header['JENIS_BILLING']['_v']) == "" ? "NULL" : "" . strtoupper(trim($header['JENIS_BILLING']['_v'])) . "";
    $NO_BL_AWB = trim($header['NO_BL_AWB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_BL_AWB']['_v'])) . "'";
    $TGL_STRIPPING = trim($header['TGL_STRIPPING']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_STRIPPING']['_v'])) . "','%Y%m%d')";
    $TGL_KELUAR_LAMA = trim($header['TGL_KELUAR_LAMA']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_KELUAR_LAMA']['_v'])) . "','%Y%m%d')";
    $TGL_KELUAR = trim($header['TGL_KELUAR']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_KELUAR']['_v'])) . "','%Y%m%d')";
    $NO_DO = trim($header['NO_DO']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_DO']['_v'])) . "'";
    $TGL_DO = trim($header['TGL_DO']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_DO']['_v'])) . "','%Y%m%d')";
    $TGL_EXP_DO = trim($header['TGL_EXP_DO']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_EXP_DO']['_v'])) . "','%Y%m%d')";
    $NAMA_PBM = trim($header['NAMA_PBM']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NAMA_PBM']['_v'])) . "'";
    $NPWP_PBM = trim($header['NPWP_PBM']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NPWP_PBM']['_v'])) . "'";
    $ALAMAT_PBM = trim($header['ALAMAT_PBM']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['ALAMAT_PBM']['_v'])) . "'";
    $NOTA_EX = trim($header['NOTA_EX']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NOTA_EX']['_v'])) . "";
    $NO_CONTAINER_ASAL = trim($header['NO_CONTAINER_ASAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_CONTAINER_ASAL']['_v'])) . "'";
    $JENIS_DOKUMEN = trim($header['JENIS_DOKUMEN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['JENIS_DOKUMEN']['_v'])) . "'";
    $NO_DOKUMEN = trim($header['NO_DOKUMEN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_DOKUMEN']['_v'])) . "'";
    $TGL_DOKUMEN = trim($header['TGL_DOKUMEN']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_DOKUMEN']['_v'])) . "','%Y%m%d')";
    $CONSIGNEE = trim($header['CONSIGNEE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['CONSIGNEE']['_v'])) . "'";
    $NPWP_CONSIGNEE = trim($header['NPWP_CONSIGNEE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NPWP_CONSIGNEE']['_v'])) . "'";
    $ALAMAT_CONSIGNEE = trim($header['ALAMAT_CONSIGNEE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['ALAMAT_CONSIGNEE']['_v'])) . "'";
    $NAMA_KAPAL = trim($header['NAMA_KAPAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NAMA_KAPAL']['_v'])) . "'";
    $NO_VOYAGE = trim($header['NO_VOYAGE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_VOYAGE']['_v'])) . "'";
    $TANGGAL_TIBA = trim($header['TANGGAL_TIBA']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TANGGAL_TIBA']['_v'])) . "','%Y%m%d')";
    $SUBTOTAL = trim($header['SUB_TOTAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['SUB_TOTAL']['_v'])) . "'";
    $PPN = trim($header['PPN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['PPN']['_v'])) . "'";
    $TOTAL = trim($header['TOTAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['TOTAL']['_v'])) . "'";
    //$JENIS_BAYAR = trim($header['JENIS_BAYAR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['JENIS_BAYAR']['_v'])) . "'";

    /* BEGIN Generate jenis transaksi */
    /* END Generate jenis transaksi */
    $KD_GUDANG = (strpos($NO_ORDER, "01") == 2) ? 'RAYA' : 'BAND';
    /* BEGIN Generate kode proforma */
    if ($JENIS_BILLING == 1) {
        $kodetrx = "02";
    } elseif ($JENIS_BILLING == 2) {
        $kodetrx = "01";
    }
    $kdtglpro = date('Ymd');

    $SQLselectidbef = "SELECT substr(A.NO_PROFORMA_INVOICE, 12) AS NO_PROFORMA_INVOICE FROM t_billing_cfshdr A WHERE A.ID = (SELECT MAX(A.ID) FROM t_billing_cfshdr A) LIMIT 1";
    $Queryselectidbef = $conn->query($SQLselectidbef);
    $Queryselectidbef->next();
    $probef = $Queryselectidbef->get("NO_PROFORMA_INVOICE");
    $pronew = $probef + 1;

    if ($pronew <= 9) {
        $pro = '0000';
    } elseif (99 >= $pronew && $pronew > 9) {
        $pro = '000';
    } elseif (999 >= $pronew && $pronew > 99) {
        $pro = '00';
    } elseif (9999 >= $pronew && $pronew > 999) {
        $pro = '0';
    } elseif (99999 >= $pronew && $pronew > 9999) {
        $pro = '';
    }
    $prourut = $pro . $pronew;

    $NO_PROFORMA = $kodetrx . "-" . $kdtglpro . $prourut;
    $IDbilling='';
    /* END Generate kode proforma */
    /* End Generate data header */
	$NPWP = ($NPWP_PBM=="NULL")?$NPWP_CONSIGNEE:$NPWP_PBM;
	if($NPWP == "NULL"){
		$KET = 'NPWP customer tidak boleh kosong.';
	}else{
		$KET = 'Customer belum terdaftar atau tidak aktif di sistem CDM. Silahkan hubungi CS Cabang Tanjung Priok.';
	}
	//echo $NPWP." - ".$NPWP_CONSIGNEE." - ".$NPWP_PBM;
	$checkbil = $conn->query("SELECT ID FROM t_billing_cfshdr WHERE NO_ORDER = '" . $NO_ORDER . "' AND NO_INVOICE IS NOT NULL");
	if ($checkbil->size() == 0) {
		$checkkadal = $conn->query("SELECT A.ID FROM t_order_hdr A WHERE A.NO_ORDER = '" . $NO_ORDER . "' and A.KD_STATUS='600'");
		if ($checkkadal->size() == 0) {
			$check = $conn->query("select A.CUSTOMER_ID from mst_customer A WHERE A.STATUS_CUSTOMER='A' AND A.STATUS_APPROVAL='A' AND (A.NPWP=".$NPWP." or A.PASSPORT=".$NPWP.")");
			if ($check->size() > 0) {
				$check->next();
				$CUSTOMER_ID = $check->get("CUSTOMER_ID");
				$SQLorder = "SELECT A.ID FROM t_order_hdr A WHERE A.NO_ORDER = '" . $NO_ORDER . "'";
				$Queryorder = $conn->query($SQLorder);
				if ($Queryorder->size() == 0) {
					$SQLHeaderorder = "INSERT INTO t_order_hdr(NO_ORDER,JENIS_TRANSAKSI,JENIS_BILLING,JENIS_BAYAR,EX_NOTA,CUSTOMER_NUMBER,TGL_KELUAR_LAMA,TGL_KELUAR,NO_BL_AWB,TGL_STRIPPING,NO_DO,TGL_DO,TGL_EXPIRED_DO,NAMA_FORWARDER,NPWP_FORWARDER,ALAMAT_FORWARDER,CONSIGNEE,NPWP_CONSIGNEE,ALAMAT_CONSIGNEE,KD_GUDANG_TUJUAN,NO_CONT_ASAL,NM_ANGKUT,NO_VOYAGE,TGL_TIBA,KD_KPBC,KODE_DOK,NO_SPPB,TGL_SPPB,ID_USER,WK_REKAM) VALUES('" . $NO_ORDER . "'," . $JENIS_TRANSAKSI . ",'" . $JENIS_BILLING . "','A'," . $NOTA_EX . ",'" . $CUSTOMER_ID . "'," . $TGL_KELUAR_LAMA . "," . $TGL_KELUAR . "," . $NO_BL_AWB . "," . $TGL_STRIPPING . "," . $NO_DO . "," . $TGL_DO . "," . $TGL_EXP_DO . "," . $NAMA_PBM . "," . $NPWP_PBM . "," . $ALAMAT_PBM . "," . $CONSIGNEE . "," . $NPWP_CONSIGNEE . "," . $ALAMAT_CONSIGNEE . ",'" . $KD_GUDANG . "'," . $NO_CONTAINER_ASAL . "," . $NAMA_KAPAL . "," . $NO_VOYAGE . "," . $TANGGAL_TIBA . ",'040300'," . $JENIS_DOKUMEN . "," . $NO_DOKUMEN . "," . $TGL_DOKUMEN . ",'1',NOW());";
					$Execute = $conn->execute($SQLHeaderorder);
					if ($Execute == "") {
						$sqlerror = 'Gagal insert data header';
					}
				} else {
					$Queryorder->next();
					$ID = $Queryorder->get("ID");
					$SQLHeaderorder = "UPDATE t_order_hdr SET NO_ORDER='" . $NO_ORDER . "', JENIS_TRANSAKSI=" . $JENIS_TRANSAKSI . ", JENIS_BILLING='" . $JENIS_BILLING . "', JENIS_BAYAR='A', EX_NOTA=" . $NOTA_EX . ", CUSTOMER_NUMBER='" . $CUSTOMER_ID . "', TGL_KELUAR_LAMA=" . $TGL_KELUAR_LAMA . ", TGL_KELUAR=" . $TGL_KELUAR . ", NO_BL_AWB=" . $NO_BL_AWB . ", TGL_STRIPPING=" . $TGL_STRIPPING . ", NO_DO=" . $NO_DO . ",TGL_DO=" . $TGL_DO . ", TGL_EXPIRED_DO=" . $TGL_EXP_DO . ",NAMA_FORWARDER=" . $NAMA_PBM . ", NPWP_FORWARDER=" . $NPWP_PBM . ", ALAMAT_FORWARDER=" . $ALAMAT_PBM . ", CONSIGNEE=" . $CONSIGNEE . ", NPWP_CONSIGNEE=" . $NPWP_CONSIGNEE . ", ALAMAT_CONSIGNEE=" . $ALAMAT_CONSIGNEE . ", KD_GUDANG_TUJUAN='" . $KD_GUDANG . "', NO_CONT_ASAL=" . $NO_CONTAINER_ASAL . ", NM_ANGKUT=" . $NAMA_KAPAL . ", NO_VOYAGE=" . $NO_VOYAGE . ", TGL_TIBA=" . $TANGGAL_TIBA . ", KD_KPBC='040300', KODE_DOK=" . $JENIS_DOKUMEN . ", NO_SPPB=" . $NO_DOKUMEN . ", TGL_SPPB=" . $TGL_DOKUMEN . " WHERE ID='".$ID."';";
					$Execute = $conn->execute($SQLHeaderorder);
					if ($Execute == "") {
						$sqlerror = 'Gagal insert data header';
					}
					$SQLpro = "SELECT B.ID, B.NO_PROFORMA_INVOICE, B.KD_ALASAN_BILLING FROM t_billing_cfshdr B WHERE B.NO_ORDER = '" . $NO_ORDER . "' order by B.ID desc limit 1";
					$Querypro = $conn->query($SQLpro);
					if ($Querypro->size() > 0) {
						$Querypro->next();
						$IDbilling = $Querypro->get("ID");
						//$NO_PROFORMA = $Querypro->get("NO_PROFORMA_INVOICE");
						//$approve = $Querypro->get("KD_ALASAN_BILLING");
					}
				}
				if ($sqlerror == "") {
					$SQLHeader = "INSERT INTO t_billing_cfshdr(JENIS_BILLING,NO_ORDER,TGL_UPDATE,SUBTOTAL,PPN,TOTAL,FLAG_APPROVE,KD_ALASAN_BILLING,JENIS_BAYAR,NO_PROFORMA_INVOICE) VALUES('" . $JENIS_BILLING . "','" . $NO_ORDER . "',
					NOW()," . $SUBTOTAL . "," . $PPN . "," . $TOTAL . ",'N','REJECT','A','" . $NO_PROFORMA . "');";
					$Execute = $conn->execute($SQLHeader);
					if ($Execute != "") {
						//detail
						$IDHeader = mysql_insert_id();
						$countTarif = 0;
						$countTarif = count($detil['TARIF']);
						$message .= '<LOADBILLING>';
						$message .= '<HEADER>';
						$message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
						$message .= '</HEADER>';
						$message .= '<DETIL>';
						$messagetarif = '';
						$countreject = 0;
						if ($countTarif > 1) {
							for ($i = 0; $i < $countTarif; $i++) {
								$chektarif = cektarif($detil['TARIF'][$i]['_c'], $NO_ORDER);
								$chektarif = explode("|", $chektarif);
								$RES = $chektarif[0];
								$countreject += ($RES == "REJECT") ? 1 : 0;
								$messagetarif .= $chektarif[1];
							}
						} elseif ($countTarif == 1) {
							$chektarif = cektarif($detil['TARIF']['_c'], $NO_ORDER);
							$chektarif = explode("|", $chektarif);
							$RES = $chektarif[0];
							$countreject += ($RES == "REJECT") ? 1 : 0;
							$messagetarif .= $chektarif[1];
						}
						if ($countTarif > 1) {
							for ($i = 0; $i < $countTarif; $i++) {
								insertdetiltarif($detil, $detil['TARIF'][$i]['_c'], $IDHeader);
							}
						} elseif ($countTarif == 1) {
							insertdetiltarif($detil, $detil['TARIF']['_c'], $IDHeader);
						}
						$SQLsub = "select sum(A.TOTAL) as SUBTOT,B.SUBTOTAL from t_billing_cfsdtl A join t_billing_cfshdr B on A.ID=B.ID
						WHERE B.ID = '" . $IDHeader . "'";
						$Querysub = $conn->query($SQLsub);
						if ($Querysub->size() > 0) {
							$Querysub->next();
							$SUBTOT = $Querysub->get("SUBTOT");
							$SUBTOT2 = $Querysub->get("SUBTOTAL");
							if ($SUBTOT == $SUBTOT2) {
								$RES = ($countreject == 0) ? "ACCEPT" : "REJECT";
							} else {
								$RES = "REJECT";
								if ($messagetarif == "") {
									$messagetarif .= '<ALASAN_REJECT>';
									$messagetarif .= '<KD_TARIF></KD_TARIF>';
									$messagetarif .= '<KETERANGAN>Total header tidak sama dengan jumlah total detail</KETERANGAN>';
									$messagetarif .= '</ALASAN_REJECT>';
								}
							}
						} else {
							$RES = "REJECT";
							$messagetarif .= '<ALASAN_REJECT>';
							$messagetarif .= '<KD_TARIF></KD_TARIF>';
							$messagetarif .= '<KETERANGAN>Gagal insert data billing</KETERANGAN>';
							$messagetarif .= '</ALASAN_REJECT>';
						}
						$message .= '<RESPON>' . $RES . '</RESPON>';
						$message .= $messagetarif;
						$message .= '</DETIL>';
						$message .= '</LOADBILLING>';

						if($RES == 'REJECT'){
							$KODSTAT = "KD_STATUS = '400'";
							$FLAG = 'N';
						}else{
							$KODSTAT = "KD_STATUS = '500', TGL_STATUS=NOW()";
							$FLAG = 'Y';
							if($IDbilling!=""){
								$SQLUpdateBillingHDR = "UPDATE t_billing_cfshdr SET FLAG_APPROVE='N' WHERE NO_ORDER = '" . $NO_ORDER . "' AND ID = '" . $IDbilling . "'; ";
								$Execute = $conn->execute($SQLUpdateBillingHDR);
							}
						}
						$SQLUpdateBillingOrder = "UPDATE t_order_hdr SET " . $KODSTAT . " WHERE NO_ORDER = '" . $NO_ORDER . "'; ";
						$Execute = $conn->execute($SQLUpdateBillingOrder);

						$SQLUpdateBillingHDR = "UPDATE t_billing_cfshdr SET KD_ALASAN_BILLING = '" . $RES . "', FLAG_APPROVE='" . $FLAG . "' WHERE NO_ORDER = '" . $NO_ORDER . "' AND ID = '" . $IDHeader . "'; ";
						$Execute = $conn->execute($SQLUpdateBillingHDR);

						$SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
						$Execute = $conn->execute($SQL);
					} else {
						$message .= '<LOADBILLING>';
						$message .= '<HEADER>';
						$message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
						$message .= '</HEADER>';
						$message .= '<DETIL>';
						$message .= '<RESPON>REJECT</RESPON>';
						$message .= '<ALASAN_REJECT>';
						$message .= '<KD_TARIF></KD_TARIF>';
						$message .= '<KETERANGAN>Gagal insert data billing</KETERANGAN>';
						$message .= '</ALASAN_REJECT>';
						$message .= '</DETIL>';
						$message .= '</LOADBILLING>';
						$SQL = "UPDATE app_log_services SET FL_USED = '1', KETERANGAN = 'Gagal insert data billing', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
						$Execute = $conn->execute($SQL);
					}
				} else {
					$message .= '<LOADBILLING>';
					$message .= '<HEADER>';
					$message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
					$message .= '</HEADER>';
					$message .= '<DETIL>';
					$message .= '<RESPON>REJECT</RESPON>';
					$message .= '<ALASAN_REJECT>';
					$message .= '<KD_TARIF></KD_TARIF>';
					$message .= '<KETERANGAN>' . $sqlerror . '</KETERANGAN>';
					$message .= '</ALASAN_REJECT>';
					$message .= '</DETIL>';
					$message .= '</LOADBILLING>';
					$SQL = "UPDATE app_log_services SET FL_USED = '1', KETERANGAN = '" . $sqlerror . "', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
					$Execute = $conn->execute($SQL);
				}
			}else {
				$message .= '<LOADBILLING>';
				$message .= '<HEADER>';
				$message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
				$message .= '</HEADER>';
				$message .= '<DETIL>';
				$message .= '<RESPON>REJECT</RESPON>';
				$message .= '<ALASAN_REJECT>';
				$message .= '<KD_TARIF></KD_TARIF>';
				$message .= '<KETERANGAN>'.$KET.'</KETERANGAN>';
				$message .= '</ALASAN_REJECT>';
				$message .= '</DETIL>';
				$message .= '</LOADBILLING>';
				$SQL = "UPDATE app_log_services SET FL_USED = '1', KETERANGAN = 'Customer belum terdaftar', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
				$Execute = $conn->execute($SQL);
			}
		}else {
			$message .= '<LOADBILLING>';
			$message .= '<HEADER>';
			$message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
			$message .= '</HEADER>';
			$message .= '<DETIL>';
			$message .= '<RESPON>REJECT</RESPON>';
			$message .= '<ALASAN_REJECT>';
			$message .= '<KD_TARIF></KD_TARIF>';
			$message .= '<KETERANGAN>ORDER SUDAH KEDALUWARSA</KETERANGAN>';
			$message .= '</ALASAN_REJECT>';
			$message .= '</DETIL>';
			$message .= '</LOADBILLING>';
			$SQL = "UPDATE app_log_services SET FL_USED = '1', KETERANGAN = 'Order Kedaluwarsa', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);
		}
	}else {
		$message .= '<LOADBILLING>';
		$message .= '<HEADER>';
		$message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
		$message .= '</HEADER>';
		$message .= '<DETIL>';
		$message .= '<RESPON>ACCEPT</RESPON>';
		$message .= '</DETIL>';
		$message .= '</LOADBILLING>';
		$SQL = "UPDATE app_log_services SET FL_USED = '1', KETERANGAN = 'Order sudah lunas', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
		$Execute = $conn->execute($SQL);
	}

    return $message;
}

function cektarif($tarif, $no_order) {
    global $CONF, $conn;
    $message = "";
    $TARIF_DASAR = trim($tarif['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($tarif['TARIF_DASAR']['_v'])) . "";
    $KODE = trim($tarif['KODE_TARIF']['_v']) == "" ? "NULL" : "" . strtoupper(trim($tarif['KODE_TARIF']['_v'])) . "";
    $SQLKode = "SELECT a.TARIF_DASAR FROM reff_billing_cfs a WHERE a.KODE_BILL = '" . $KODE . "'";
    $QueryKode = $conn->query($SQLKode);
    if ($QueryKode->size() > 0) {
        $QueryKode->next();
        $TARIF_DASAR_CFS = $QueryKode->get("TARIF_DASAR");
        if ($TARIF_DASAR > $TARIF_DASAR_CFS) {
            $RES = 'REJECT';
            $message .= '<ALASAN_REJECT>';
            $message .= '<KD_TARIF>' . $KODE . '</KD_TARIF>';
            $message .= '<KETERANGAN>Tarif billing melebihi tarif dasar</KETERANGAN>';
            $message .= '</ALASAN_REJECT>';
        } elseif ($TARIF_DASAR < $TARIF_DASAR_CFS) {
            $RES = 'REJECT';
            $message .= '<ALASAN_REJECT>';
            $message .= '<KD_TARIF>' . $KODE . '</KD_TARIF>';
            $message .= '<KETERANGAN>Tarif billing kurang dari tarif dasar</KETERANGAN>';
            $message .= '</ALASAN_REJECT>';
        } else {
            $RES = 'ACCEPT';
        }
    } else {
        $RES = 'REJECT';
        $message .= '<ALASAN_REJECT>';
        $message .= '<KD_TARIF>' . $KODE . '</KD_TARIF>';
        $message .= '<KETERANGAN>Kode tidak sesuai dengan tarif dasar</KETERANGAN>';
        $message .= '</ALASAN_REJECT>';
    }
    return $RES . "|" . $message;
}

function insertdetiltarif($detil, $tarif, $IDHeader) {
    global $CONF, $conn;
    $TARIF_DASAR = trim($tarif['TARIF_DASAR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($tarif['TARIF_DASAR']['_v'])) . "'";
    $KODE = trim($tarif['KODE_TARIF']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($tarif['KODE_TARIF']['_v'])) . "'";
    $QTY = trim($tarif['QTY']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($tarif['QTY']['_v'])) . "'";
    $SATUAN = trim($tarif['SATUAN']['_v']) == "'" ? "NULL" : "'" . strtoupper(trim($tarif['SATUAN']['_v'])) . "'";
    $NILAI = trim($tarif['NILAI']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($tarif['NILAI']['_v'])) . "'";
    $HARI = trim($tarif['HARI']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($tarif['HARI']['_v'])) . "'";
    $JNS_KMS = trim($detil['JNS_KMS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['JNS_KMS']['_v'])) . "'";
    $MERK_KMS = trim($detil['MERK_KMS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['MERK_KMS']['_v'])) . "'";
    $JML_KMS = trim($detil['JML_KMS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['JML_KMS']['_v'])) . "'";
    $WEIGHT = trim($detil['WEIGHT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['WEIGHT']['_v'])) . "'";
    $MEASURE = trim($detil['MEASURE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['MEASURE']['_v'])) . "'";
    //insert t_billing_cfsdtl
    $SQLDetil = "INSERT INTO t_billing_cfsdtl(ID,KODE_BILL,JNS_KMS,MRK_KMS,JML_KMS,TARIF_DASAR,TOTAL,QTY,HARI,SATUAN,WEIGHT,MEASURE) 
	VALUES('" . $IDHeader . "'," . $KODE . "," . $JNS_KMS . "," . $MERK_KMS . "," . $JML_KMS . "," . $TARIF_DASAR . "," . $NILAI . "," . $QTY . "," . $HARI . "," . $SATUAN . "," . $WEIGHT . "," . $MEASURE . "); ";
    $Execute = $conn->execute($SQLDetil);
}

function insertCDM($CDM, $Type, $ID_LOG) {
    global $CONF, $conn;
    $message = 0;

    /* Begin Generate data */
		$CUSTOMER_ID_SEQ = trim($CDM['CUSTOMER_ID_SEQ']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CUSTOMER_ID_SEQ']['_v'])) . "'";
		$CUSTOMER_ID = trim($CDM['CUSTOMER_ID']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CUSTOMER_ID']['_v'])) . "'";
		$CUSTOMER_LABEL = trim($CDM['CUSTOMER_LABEL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CUSTOMER_LABEL']['_v'])) . "'";
		$NAME = trim($CDM['NAME']['_v']) == "" ? "NULL" : "'" . htmlspecialchars(strtoupper(trim($CDM['NAME']['_v']))) . "'";
		$ADDRESS = trim($CDM['ADDRESS']['_v']) == "" ? "NULL" : "'" . mysql_real_escape_string(htmlspecialchars(strtoupper(trim($CDM['ADDRESS']['_v'])))) . "'";
		$NPWP = trim($CDM['NPWP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['NPWP']['_v'])) . "'";
		$EMAIL = trim($CDM['EMAIL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['EMAIL']['_v'])) . "'";
		$WEBSITE = trim($CDM['WEBSITE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['WEBSITE']['_v'])) . "'";
		$PHONE = trim($CDM['PHONE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['PHONE']['_v'])) . "'";
		$COMPANY_TYPE = trim($CDM['COMPANY_TYPE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['COMPANY_TYPE']['_v'])) . "'";
		$ALT_NAME = trim($CDM['ALT_NAME']['_v']) == "" ? "NULL" : "'" . htmlspecialchars(strtoupper(trim($CDM['ALT_NAME']['_v']))) . "'";
		$DEED_ESTABLISHMENT = trim($CDM['DEED_ESTABLISHMENT']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CDM['DEED_ESTABLISHMENT']['_v'])) . "','%d-%b-%y')";
		$CUSTOMER_GROUP = trim($CDM['CUSTOMER_GROUP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CUSTOMER_GROUP']['_v'])) . "'";
		$CUSTOMER_TYPE = trim($CDM['CUSTOMER_TYPE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CUSTOMER_TYPE']['_v'])) . "'";
		$SVC_VESSEL = trim($CDM['SVC_VESSEL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['SVC_VESSEL']['_v'])) . "'";
		$SVC_CARGO = trim($CDM['SVC_CARGO']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['SVC_CARGO']['_v'])) . "'";
		$SVC_CONTAINER = trim($CDM['SVC_CONTAINER']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['SVC_CONTAINER']['_v'])) . "'";
		$SVC_MISC = trim($CDM['SVC_MISC']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['SVC_MISC']['_v'])) . "'";
		$IS_SUBSIDIARY = trim($CDM['IS_SUBSIDIARY']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['IS_SUBSIDIARY']['_v'])) . "'";
		$HOLDING_NAME = trim($CDM['HOLDING_NAME']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['HOLDING_NAME']['_v'])) . "'";
		$EMPLOYEE_COUNT = trim($CDM['EMPLOYEE_COUNT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['EMPLOYEE_COUNT']['_v'])) . "'";
		$IS_MAIN_BRANCH = trim($CDM['IS_MAIN_BRANCH']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['IS_MAIN_BRANCH']['_v'])) . "'";
		$PARTNERSHIP_DATE = trim($CDM['PARTNERSHIP_DATE']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CDM['PARTNERSHIP_DATE']['_v'])) . "','%d-%b-%y')";
		$PROVINCE = trim($CDM['PROVINCE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['PROVINCE']['_v'])) . "'";
		$CITY = trim($CDM['CITY']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CITY']['_v'])) . "'";
		$CITY_TYPE = trim($CDM['CITY_TYPE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CITY_TYPE']['_v'])) . "'";
		$KECAMATAN = trim($CDM['KECAMATAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['KECAMATAN']['_v'])) . "'";
		$KELURAHAN = trim($CDM['KELURAHAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['KELURAHAN']['_v'])) . "'";
		$POSTAL_CODE = trim($CDM['POSTAL_CODE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['POSTAL_CODE']['_v'])) . "'";
		$FAX = trim($CDM['FAX']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['FAX']['_v'])) . "'";
		$PARENT_ID = trim($CDM['PARENT_ID']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['PARENT_ID']['_v'])) . "'";
		$CREATE_BY = trim($CDM['CREATE_BY']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CREATE_BY']['_v'])) . "'";
		$CREATE_DATE = trim($CDM['CREATE_DATE']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CDM['CREATE_DATE']['_v'])) . "','%d-%b-%y')";
		$CREATE_VIA = trim($CDM['CREATE_VIA']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CREATE_VIA']['_v'])) . "'";
		$CREATE_IP = trim($CDM['CREATE_IP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CREATE_IP']['_v'])) . "'";
		$EDIT_BY = trim($CDM['EDIT_BY']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['EDIT_BY']['_v'])) . "'";
		$EDIT_DATE = trim($CDM['EDIT_DATE']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CDM['EDIT_DATE']['_v'])) . "','%d-%b-%y')";
		$EDIT_VIA = trim($CDM['EDIT_VIA']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['EDIT_VIA']['_v'])) . "'";
		$EDIT_IP = trim($CDM['EDIT_IP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['EDIT_IP']['_v'])) . "'";
		$IS_SHIPPING_AGENT = trim($CDM['IS_SHIPPING_AGENT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['IS_SHIPPING_AGENT']['_v'])) . "'";
		$IS_SHIPPING_LINE = trim($CDM['IS_SHIPPING_LINE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['IS_SHIPPING_LINE']['_v'])) . "'";
		$REG_TYPE = trim($CDM['REG_TYPE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['REG_TYPE']['_v'])) . "'";
		$IS_PBM = trim($CDM['IS_PBM']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['IS_PBM']['_v'])) . "'";
		$IS_FF = trim($CDM['IS_FF']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['IS_FF']['_v'])) . "'";
		$IS_EMKL = trim($CDM['IS_EMKL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['IS_EMKL']['_v'])) . "'";
		$IS_PPJK = trim($CDM['IS_PPJK']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['IS_PPJK']['_v'])) . "'";
		$IS_CONSIGNEE = trim($CDM['IS_CONSIGNEE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['IS_CONSIGNEE']['_v'])) . "'";
		$REGISTRATION_COMPANY_ID = trim($CDM['REGISTRATION_COMPANY_ID']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['REGISTRATION_COMPANY_ID']['_v'])) . "'";
		$HEADQUARTERS_ID = trim($CDM['HEADQUARTERS_ID']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['HEADQUARTERS_ID']['_v'])) . "'";
		$HEADQUARTERS_NAME = trim($CDM['HEADQUARTERS_NAME']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['HEADQUARTERS_NAME']['_v'])) . "'";
		$STATUS_APPROVAL = trim($CDM['STATUS_APPROVAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['STATUS_APPROVAL']['_v'])) . "'";
		$TYPE_APPROVAL = trim($CDM['TYPE_APPROVAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['TYPE_APPROVAL']['_v'])) . "'";
		$STATUS_CUSTOMER = trim($CDM['STATUS_CUSTOMER']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['STATUS_CUSTOMER']['_v'])) . "'";
		$CONFIRM_DATE = trim($CDM['CONFIRM_DATE']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CDM['CONFIRM_DATE']['_v'])) . "','%d-%b-%y')";
		$APPROVE_DATE = trim($CDM['APPROVE_DATE']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CDM['APPROVE_DATE']['_v'])) . "','%d-%b-%y')";
		$ACCEPTANCE_DOC = trim($CDM['ACCEPTANCE_DOC']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['ACCEPTANCE_DOC']['_v'])) . "'";
		$ACCEPTANCE_DOC_DATE = trim($CDM['ACCEPTANCE_DOC_DATE']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CDM['ACCEPTANCE_DOC_DATE']['_v'])) . "','%d-%b-%y')";
		$REJECT_NOTES = trim($CDM['REJECT_NOTES']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['REJECT_NOTES']['_v'])) . "'";
		$REJECT_USER = trim($CDM['REJECT_USER']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['REJECT_USER']['_v'])) . "'";
		$REJECT_DATE = trim($CDM['REJECT_DATE']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CDM['REJECT_DATE']['_v'])) . "','%d-%b-%y')";
		$BRANCH_SIGN = trim($CDM['BRANCH_SIGN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['BRANCH_SIGN']['_v'])) . "'";
		$PASSPORT = trim($CDM['PASSPORT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['PASSPORT']['_v'])) . "'";
		$CITIZENSHIP = trim($CDM['CITIZENSHIP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CITIZENSHIP']['_v'])) . "'";
    /* End Generate data */

    if ($Type == "insert" || $Type == "CRM") {
		$SQLorder = "SELECT CUSTOMER_ID FROM mst_customer WHERE CUSTOMER_ID = " . $CUSTOMER_ID . "";
		$Queryorder = $conn->query($SQLorder);
		if ($Queryorder->size() == 0) {
			$SQLHeaderorder = "INSERT INTO mst_customer (CUSTOMER_ID, CUSTOMER_LABEL, NAME, ADDRESS, NPWP, EMAIL, WEBSITE, PHONE, COMPANY_TYPE, ALT_NAME, DEED_ESTABLISHMENT, CUSTOMER_GROUP, CUSTOMER_TYPE, SVC_VESSEL, SVC_CARGO, SVC_CONTAINER, SVC_MISC, IS_SUBSIDIARY, HOLDING_NAME, EMPLOYEE_COUNT, IS_MAIN_BRANCH, PARTNERSHIP_DATE, PROVINCE, CITY, CITY_TYPE, KECAMATAN, KELURAHAN, POSTAL_CODE, FAX, PARENT_ID, CREATE_BY, CREATE_DATE, CREATE_VIA, CREATE_IP, EDIT_BY, EDIT_DATE, EDIT_VIA, EDIT_IP, IS_SHIPPING_AGENT, IS_SHIPPING_LINE, REG_TYPE, IS_PBM, IS_FF, IS_EMKL, IS_PPJK, IS_CONSIGNEE, REGISTRATION_COMPANY_ID, HEADQUARTERS_ID, HEADQUARTERS_NAME, STATUS_APPROVAL, TYPE_APPROVAL, STATUS_CUSTOMER, CONFIRM_DATE, APPROVE_DATE, ACCEPTANCE_DOC, ACCEPTANCE_DOC_DATE, REJECT_NOTES, REJECT_USER, REJECT_DATE, BRANCH_SIGN, PASSPORT, CITIZENSHIP) VALUES(" . $CUSTOMER_ID . "," . $CUSTOMER_LABEL . ",
			" . $NAME . "," . $ADDRESS . "," . $NPWP . "," . $EMAIL . "," . $WEBSITE . "," . $PHONE . "," . $COMPANY_TYPE . ",
			" . $ALT_NAME . "," . $DEED_ESTABLISHMENT . "," . $CUSTOMER_GROUP . "," . $CUSTOMER_TYPE . "," . $SVC_VESSEL . ",
			" . $SVC_CARGO . "," . $SVC_CONTAINER . "," . $SVC_MISC . "," . $IS_SUBSIDIARY . "," . $HOLDING_NAME . ",
			" . $EMPLOYEE_COUNT . "," . $IS_MAIN_BRANCH . "," . $PARTNERSHIP_DATE . "," . $PROVINCE . "," . $CITY . ",
			" . $CITY_TYPE . "," . $KECAMATAN . "," . $KELURAHAN . "," . $POSTAL_CODE . "," . $FAX . "," . $PARENT_ID . ",
			" . $CREATE_BY . "," . $CREATE_DATE . "," . $CREATE_VIA . "," . $CREATE_IP . "," . $EDIT_BY . "," . $EDIT_DATE . ",
			" . $EDIT_VIA . "," . $EDIT_IP . "," . $IS_SHIPPING_AGENT . "," . $IS_SHIPPING_LINE . "," . $REG_TYPE . ",
			" . $IS_PBM . "," . $IS_FF . "," . $IS_EMKL . "," . $IS_PPJK . "," . $IS_CONSIGNEE . "," . $REGISTRATION_COMPANY_ID . ",
			" . $HEADQUARTERS_ID . "," . $HEADQUARTERS_NAME . "," . $STATUS_APPROVAL . "," . $TYPE_APPROVAL . ",
			" . $STATUS_CUSTOMER . "," . $CONFIRM_DATE . "," . $APPROVE_DATE . "," . $ACCEPTANCE_DOC . ",
			" . $ACCEPTANCE_DOC_DATE . "," . $REJECT_NOTES . "," . $REJECT_USER . "," . $REJECT_DATE . "," . $BRANCH_SIGN . ",
			" . $PASSPORT . "," . $CITIZENSHIP . ");";
			//echo $SQLHeaderorder;
			$Execute = $conn->execute($SQLHeaderorder);
			if ($Execute == "") {
				$message = 0;
			}else{
				$message = 1;
			}
		}else{
			$Queryorder->next();
			$CUSTOMER_ID = $Queryorder->get("CUSTOMER_ID");
			$SQLHeaderorder = "UPDATE mst_customer SET CUSTOMER_LABEL=" . $CUSTOMER_LABEL . ", 
			NAME=" . $NAME . ", ADDRESS=" . $ADDRESS . ", NPWP=" . $NPWP . ", EMAIL=" . $EMAIL . ", WEBSITE=" . $WEBSITE . ",
			PHONE=" . $PHONE . ", COMPANY_TYPE=" . $COMPANY_TYPE . ", ALT_NAME=" . $ALT_NAME . ", 
			DEED_ESTABLISHMENT=" . $DEED_ESTABLISHMENT . ", CUSTOMER_GROUP=" . $CUSTOMER_GROUP . ", 
			CUSTOMER_TYPE=" . $CUSTOMER_TYPE . ", SVC_VESSEL=" . $SVC_VESSEL . ", SVC_CARGO=" . $SVC_CARGO . ", 
			SVC_CONTAINER=" . $SVC_CONTAINER . ", SVC_MISC=" . $SVC_MISC . ", IS_SUBSIDIARY=" . $IS_SUBSIDIARY . ", 
			HOLDING_NAME=" . $HOLDING_NAME . ", EMPLOYEE_COUNT=" . $EMPLOYEE_COUNT . ", IS_MAIN_BRANCH=" . $IS_MAIN_BRANCH . ", 
			PARTNERSHIP_DATE=" . $PARTNERSHIP_DATE . ",PROVINCE=" . $PROVINCE . ",CITY=" . $CITY . ",CITY_TYPE=" . $CITY_TYPE . ", 
			KECAMATAN=" . $KECAMATAN . ", KELURAHAN=" . $KELURAHAN . ", POSTAL_CODE=" . $POSTAL_CODE . ", FAX=" . $FAX . ", 
			PARENT_ID=" . $PARENT_ID . ", CREATE_BY=" . $CREATE_BY . ", CREATE_DATE=" . $CREATE_DATE . ", 
			CREATE_VIA=" . $CREATE_VIA . ", CREATE_IP=" . $CREATE_IP . ", EDIT_BY=" . $EDIT_BY . ", EDIT_DATE=" . $EDIT_DATE . ", 
			EDIT_VIA=" . $EDIT_VIA . ", EDIT_IP=" . $EDIT_IP . ", IS_SHIPPING_AGENT=" . $IS_SHIPPING_AGENT . ", 
			IS_SHIPPING_LINE=" . $IS_SHIPPING_LINE . ", REG_TYPE=" . $REG_TYPE . ", IS_PBM=" . $IS_PBM . ", IS_FF=" . $IS_FF . ", 
			IS_EMKL=" . $IS_EMKL . ", IS_PPJK=" . $IS_PPJK . ", IS_CONSIGNEE=" . $IS_CONSIGNEE . ", 
			REGISTRATION_COMPANY_ID=" . $REGISTRATION_COMPANY_ID . ", HEADQUARTERS_ID=" . $HEADQUARTERS_ID . ", 
			HEADQUARTERS_NAME=" . $HEADQUARTERS_NAME . ", STATUS_APPROVAL=" . $STATUS_APPROVAL . ", 
			TYPE_APPROVAL=" . $TYPE_APPROVAL . ", STATUS_CUSTOMER=" . $STATUS_CUSTOMER . ", CONFIRM_DATE=" . $CONFIRM_DATE . ", 
			APPROVE_DATE=" . $APPROVE_DATE . ", ACCEPTANCE_DOC=" . $ACCEPTANCE_DOC . ", 
			ACCEPTANCE_DOC_DATE=" . $ACCEPTANCE_DOC_DATE . ",REJECT_NOTES=" . $REJECT_NOTES . ",REJECT_USER=" . $REJECT_USER . ", 
			REJECT_DATE=" . $REJECT_DATE . ", BRANCH_SIGN=" . $BRANCH_SIGN . ", PASSPORT=" . $PASSPORT . ", 
			CITIZENSHIP=" . $CITIZENSHIP . " WHERE CUSTOMER_ID='".$CUSTOMER_ID."';";
			//echo $SQLHeaderorder;die();
			$Execute = $conn->execute($SQLHeaderorder);
			if ($Execute == "") {
				$message = 0;
			}else{
				$message = 1;
			}
		}
    } elseif($Type == "update") {
        $SQLHeaderorder = "UPDATE mst_customer SET CUSTOMER_LABEL=" . $CUSTOMER_LABEL . ", 
		NAME=" . $NAME . ", ADDRESS=" . $ADDRESS . ", NPWP=" . $NPWP . ", EMAIL=" . $EMAIL . ", WEBSITE=" . $WEBSITE . ",
		PHONE=" . $PHONE . ", COMPANY_TYPE=" . $COMPANY_TYPE . ", ALT_NAME=" . $ALT_NAME . ", 
		DEED_ESTABLISHMENT=" . $DEED_ESTABLISHMENT . ", CUSTOMER_GROUP=" . $CUSTOMER_GROUP . ", 
		CUSTOMER_TYPE=" . $CUSTOMER_TYPE . ", SVC_VESSEL=" . $SVC_VESSEL . ", SVC_CARGO=" . $SVC_CARGO . ", 
		SVC_CONTAINER=" . $SVC_CONTAINER . ", SVC_MISC=" . $SVC_MISC . ", IS_SUBSIDIARY=" . $IS_SUBSIDIARY . ", 
		HOLDING_NAME=" . $HOLDING_NAME . ", EMPLOYEE_COUNT=" . $EMPLOYEE_COUNT . ", IS_MAIN_BRANCH=" . $IS_MAIN_BRANCH . ", 
		PARTNERSHIP_DATE=" . $PARTNERSHIP_DATE . ", PROVINCE=" . $PROVINCE . ", CITY=" . $CITY . ", CITY_TYPE=" . $CITY_TYPE . ", 
		KECAMATAN=" . $KECAMATAN . ", KELURAHAN=" . $KELURAHAN . ", POSTAL_CODE=" . $POSTAL_CODE . ", FAX=" . $FAX . ", 
		PARENT_ID=" . $PARENT_ID . ", CREATE_BY=" . $CREATE_BY . ", CREATE_DATE=" . $CREATE_DATE . ", 
		CREATE_VIA=" . $CREATE_VIA . ", CREATE_IP=" . $CREATE_IP . ", EDIT_BY=" . $EDIT_BY . ", EDIT_DATE=" . $EDIT_DATE . ", 
		EDIT_VIA=" . $EDIT_VIA . ", EDIT_IP=" . $EDIT_IP . ", IS_SHIPPING_AGENT=" . $IS_SHIPPING_AGENT . ", 
		IS_SHIPPING_LINE=" . $IS_SHIPPING_LINE . ", REG_TYPE=" . $REG_TYPE . ", IS_PBM=" . $IS_PBM . ", IS_FF=" . $IS_FF . ", 
		IS_EMKL=" . $IS_EMKL . ", IS_PPJK=" . $IS_PPJK . ", IS_CONSIGNEE=" . $IS_CONSIGNEE . ", 
		REGISTRATION_COMPANY_ID=" . $REGISTRATION_COMPANY_ID . ", HEADQUARTERS_ID=" . $HEADQUARTERS_ID . ", 
		HEADQUARTERS_NAME=" . $HEADQUARTERS_NAME . ", STATUS_APPROVAL=" . $STATUS_APPROVAL . ", 
		TYPE_APPROVAL=" . $TYPE_APPROVAL . ", STATUS_CUSTOMER=" . $STATUS_CUSTOMER . ", CONFIRM_DATE=" . $CONFIRM_DATE . ", 
		APPROVE_DATE=" . $APPROVE_DATE . ", ACCEPTANCE_DOC=" . $ACCEPTANCE_DOC . ", 
		ACCEPTANCE_DOC_DATE=" . $ACCEPTANCE_DOC_DATE . ", REJECT_NOTES=" . $REJECT_NOTES . ", REJECT_USER=" . $REJECT_USER . ", 
		REJECT_DATE=" . $REJECT_DATE . ", BRANCH_SIGN=" . $BRANCH_SIGN . ", PASSPORT=" . $PASSPORT . ", 
		CITIZENSHIP=" . $CITIZENSHIP . " WHERE CUSTOMER_ID=".$CUSTOMER_ID.";";
        echo $SQLHeaderorder;
		$Execute = $conn->execute($SQLHeaderorder);
        if ($Execute == "") {
            $message = 0;
        }else{
			$message = 1;
		}
    }
    return $message;
}

function InsertPLPResponTujuan($RESPONPLP) {
    global $CONF, $conn;
    $header = $RESPONPLP['HEADER']['_c'];
    $KD_KANTOR = trim($header['KD_KANTOR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_KANTOR']['_v'])) . "'";
    $KD_TPS = trim($header['KD_TPS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_TPS']['_v'])) . "'";
    $KD_TPS_ASAL = trim($header['KD_TPS_ASAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_TPS_ASAL']['_v'])) . "'";
    $GUDANG_TUJUAN = trim($header['GUDANG_TUJUAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['GUDANG_TUJUAN']['_v'])) . "'";
    $NO_PLP = trim($header['NO_PLP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_PLP']['_v'])) . "'";
    $TGL_PLP = trim($header['TGL_PLP']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_PLP']['_v'])) . "','%Y%m%d')";
    $CALL_SIGN = trim($header['CALL_SIGN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['CALL_SIGN']['_v'])) . "'";
    $NM_ANGKUT = trim($header['NM_ANGKUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NM_ANGKUT']['_v'])) . "'";
    $NO_VOY_FLIGHT = trim($header['NO_VOY_FLIGHT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_VOY_FLIGHT']['_v'])) . "'";
    $TGL_TIBA = trim($header['TGL_TIBA']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_TIBA']['_v'])) . "','%Y%m%d')";
    //add tag element
    $NO_BC11 = trim($header['NO_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_BC11']['_v'])) . "'";
    $TGL_BC11 = trim($header['TGL_BC11']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_BC11']['_v'])) . "','%Y%m%d')";
    $NO_SURAT = trim($header['NO_SURAT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_SURAT']['_v'])) . "'";
    $TGL_SURAT = trim($header['TGL_SURAT']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_SURAT']['_v'])) . "','%Y%m%d')";

    $SQL = "SELECT ID
            FROM t_respon_plp_tujuan_v2_hdr
            WHERE NO_PLP = " . $NO_PLP . " 
                  AND TGL_PLP = " . $TGL_PLP . "";
    $Query = $conn->query($SQL);
    if ($Query->size() == 0) {
        $SQL = "INSERT INTO t_respon_plp_tujuan_v2_hdr (KD_KPBC, KD_TPS_ASAL, KD_TPS_TUJUAN, KD_GUDANG_TUJUAN, 
                                                        NO_PLP, TGL_PLP, NO_SURAT, TGL_SURAT, NM_ANGKUT, 
                                                        NO_VOY_FLIGHT, CALL_SIGN, TGL_TIBA, NO_BC11, TGL_BC11, 
                                                        TGL_STATUS)
                VALUES (" . $KD_KANTOR . ", " . $KD_TPS_ASAL . ", " . $KD_TPS . ", " . $GUDANG_TUJUAN . ", " . $NO_PLP . ", 
                        " . $TGL_PLP . ", " . $NO_SURAT . ", " . $TGL_SURAT . ", " . $NM_ANGKUT . ", " . $NO_VOY_FLIGHT . ", 
                        " . $CALL_SIGN . ", " . $TGL_TIBA . ", " . $NO_BC11 . ", " . $TGL_BC11 . ", NOW())";
        $Execute = $conn->execute($SQL);
        if ($Execute) {
            $ID = mysql_insert_id();
        } else {
            $sqlerror = "Gagal Insert header. NO PLP : $NO_PLP";
			$boolean=0;$msg=$sqlerror;
        }

        if ($ID != '') {
            $SQL = "SELECT ID
                    FROM t_cocostshdr
                    WHERE KD_ASAL_BRG = '2'
                          AND NO_BC11 = " . $NO_BC11 . "
                          AND TGL_BC11 = " . $TGL_BC11 . "";
            $Query = $conn->query($SQL);
            if ($Query->size() > 0) {
                $Query->next();
                $ID_T_COCOSTSHDR = $Query->get("ID");
            } else {
                $SQL = "INSERT INTO t_cocostshdr (KD_ASAL_BRG, KD_TPS, KD_GUDANG, KD_KAPAL, NM_ANGKUT, NO_VOY_FLIGHT, 
                                              TGL_TIBA, KD_PEL_MUAT, KD_PEL_TRANSIT, KD_PEL_BONGKAR, NO_BC11, 
                                              TGL_BC11, CARMANIF, WK_REKAM)
                    VALUES ('2', " . $KD_TPS . ", " . $GUDANG_TUJUAN . ", NULL, " . $NM_ANGKUT . ", " . $NO_VOY_FLIGHT . ", 
                            " . $TGL_TIBA . ", NULL, NULL, NULL, " . $NO_BC11 . ", 
                            " . $TGL_BC11 . ", NULL, NOW())";
                $Execute = $conn->execute($SQL);
				if(!$Execute){
					$sqlerror = "Gagal Insert header. NO PLP : $NO_PLP";
					$boolean=0;$msg=$sqlerror;
                }else{
					$ID_T_COCOSTSHDR = mysql_insert_id();
				}
            }
            // INSERT INTO t_cocostshdr END
            //DETIL KEMASAN DAN KONTAINER
            $detil = $RESPONPLP['DETIL']['_c'];

            //KEMASAN
            $countKMS = count($detil['KMS']);
            if ($countKMS > 1) {
                for ($d = 0; $d < $countKMS; $d++) {
                    $KMS = $detil['KMS'][$d]['_c'];
                    $return_det = InsertKemasan($ID, $KMS, $ID_T_COCOSTSHDR);
					$return_det = explode("|",$return_det);
					$return = $return_det[1];
					if($return_det[0]==0){$boolean=0;break;}
					else{$boolean=1;}
					$msg=$return_det[1];
                }
            } else if ($countKMS == 1) {
                $KMS = $detil['KMS']['_c'];
                $return_det = InsertKemasan($ID, $KMS, $ID_T_COCOSTSHDR);
				$return_det = explode("|",$return_det);
				if($return_det[0]==0) $boolean=0;
				else $boolean=1;
				$msg=$return_det[1];
            }

            //KONTAINER
            $countCONT = count($detil['CONT']);
            if ($countCONT > 1) {
                for ($d = 0; $d < $countCONT; $d++) {
                    $CONT = $detil['CONT'][$d]['_c'];
                    $return_det = InsertKontainer($ID, $CONT, $ID_T_COCOSTSHDR);
					$return_det = explode("|",$return_det);
					$return = $return_det[1];
					if($return_det[0]==0){$boolean=0;break;}
					else{$boolean=1;}
					$msg=$return_det[1];
                }
            } elseif ($countCONT == 1) {
                $CONT = $detil['CONT']['_c'];
                $return_det = InsertKontainer($ID, $CONT, $ID_T_COCOSTSHDR);
				$return_det = explode("|",$return_det);
				if($return_det[0]==0) $boolean=0;
				else $boolean=1;
				$msg=$return_det[1];
            }
			
			if($boolean==1) $msg='Proses Berhasil Tersimpan di CFS Portal.';
        }
    }
	return $boolean.'|'.$msg;
}

function InsertKemasan($ID, $KMS, $ID_T_COCOSTSHDR) {
    global $CONF, $conn;
    $JNS_KMS = trim($KMS['JNS_KMS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['JNS_KMS']['_v'])) . "'";
    $JML_KMS = trim($KMS['JML_KMS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['JML_KMS']['_v'])) . "'";
    $NO_BL_AWB = trim($KMS['NO_BL_AWB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['NO_BL_AWB']['_v'])) . "'";
    $TGL_BL_AWB = trim($KMS['TGL_BL_AWB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($KMS['TGL_BL_AWB']['_v'])) . "','%Y%m%d')";

    $SQL = "INSERT INTO t_respon_plp_tujuan_v2_kms (ID, KD_KEMASAN, JML_KMS, NO_BL_AWB, TGL_BL_AWB)
            VALUES (" . $ID . ", " . $JNS_KMS . ", " . $JML_KMS . ", " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ")";
    $Execute = $conn->execute($SQL);
	if($Execute){
		$SQL = "SELECT IFNULL(MAX(SERI),0) AS MAX_SERI
				FROM t_cocostskms 
				WHERE ID = " . $ID_T_COCOSTSHDR . "";
		$QueryDetail = $conn->query($SQL);
		$QueryDetail->next();
		$MAX_SERI = $QueryDetail->get("MAX_SERI");
		$NEXT_SERI = intval($MAX_SERI) + intval(1);

		$SQL = "SELECT NO_PLP, TGL_PLP
				FROM t_respon_plp_tujuan_v2_hdr
				WHERE ID = " . $ID . "";
		$QueryDetail = $conn->query($SQL);
		$QueryDetail->next();
		$NO_PLP = $QueryDetail->get("NO_PLP");
		$TGL_PLP = $QueryDetail->get("TGL_PLP");

		$SQL = "INSERT INTO t_cocostskms (ID, SERI, KD_KEMASAN, JUMLAH, ID_CONT_ASAL, NO_CONT_ASAL, BRUTO, NO_SEGEL, 
										  KONDISI_SEGEL, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, 
										  NO_POS_BC11, KD_ORG_CONSIGNEE, KD_TIMBUN_KAPAL, KD_TIMBUN, KD_PEL_MUAT, 
										  KD_PEL_TRANSIT, KD_PEL_BONGKAR, KD_DOK_IN, NO_DOK_IN, TGL_DOK_IN, WK_IN, 
										  KD_CONT_STATUS_IN, KD_SARANA_ANGKUT_IN, NO_POL_IN, KD_DOK_OUT, NO_DOK_OUT, 
										  TGL_DOK_OUT, WK_OUT, KD_CONT_STATUS_OUT, KD_SARANA_ANGKUT_OUT, NO_POL_OUT, 
										  KD_TPS_TUJUAN, KD_GUDANG_TUJUAN, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN, 
										  NO_SEGEL_BC, TGL_SEGEL_BC, NO_IJIN_TPS, TGL_IJIN_TPS, WK_REKAM)
				VALUES (" . $ID_T_COCOSTSHDR . ", '" . $NEXT_SERI . "', " . $JNS_KMS . ", " . $JML_KMS . ", NULL, NULL, NULL, NULL, 
						NULL, " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ", NULL, NULL, 
						NULL, NULL, NULL, NULL, NULL, 
						NULL, NULL, '3', '" . $NO_PLP . "', '" . $TGL_PLP . "', NULL, 
						NULL, NULL, NULL, NULL, NULL, 
						NULL, NULL, NULL, NULL, NULL, 
						NULL, NULL, NULL, NULL, 
						NULL, NULL, NULL, NULL, NOW())";
		$Execute = $conn->execute($SQL);
		if($Execute){
			$sqlerror = "Berhasil Insert Kemasan. NO PLP : $NO_PLP";
			$boolean=1;$msg=$sqlerror;
		}else{
			$sqlerror = "Gagal Insert Kemasan. NO PLP : $NO_PLP";
			$boolean=0;$msg=$sqlerror;
		}
	}else{
		$sqlerror = "Gagal Insert Kemasan. NO PLP : $NO_PLP";
		$boolean=0;$msg=$sqlerror;
	}
	return $boolean.'|'.$msg;
}

function InsertKontainer($ID, $CONT, $ID_T_COCOSTSHDR) {
    global $CONF, $conn;
    $NO_CONT = trim($CONT['NO_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_CONT']['_v'])) . "'";
    $UK_CONT = trim($CONT['UK_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['UK_CONT']['_v'])) . "'";
    $JNS_CONT = trim($CONT['JNS_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['JNS_CONT']['_v'])) . "'";
    $NO_POS_BC11 = trim($CONT['NO_POS_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_POS_BC11']['_v'])) . "'";
    $CONSIGNEE = trim($CONT['CONSIGNEE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['CONSIGNEE']['_v'])) . "'";
    $NO_BL_AWB = trim($CONT['NO_BL_AWB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_BL_AWB']['_v'])) . "'";
    $TGL_BL_AWB = trim($CONT['TGL_BL_AWB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_BL_AWB']['_v'])) . "','%Y%m%d')";

    $SQL = "INSERT INTO t_respon_plp_tujuan_v2_cont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, NO_POS_BC11, CONSIGNEE, NO_BL_AWB, TGL_BL_AWB)
            VALUES (" . $ID . ", " . $NO_CONT . ", " . $UK_CONT . ", " . $JNS_CONT . ", " . $NO_POS_BC11 . ", " . $CONSIGNEE . ", " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ")";
    $Execute = $conn->execute($SQL);
	if($Execute){
		$SQL = "SELECT ID 
				FROM t_cocostscont
				WHERE ID = " . $ID_T_COCOSTSHDR . "
					  AND NO_CONT = " . $NO_CONT . "";
		$QueryDetail = $conn->query($SQL);
		if ($QueryDetail->size() == 0) {
			$SQL = "SELECT NO_PLP, TGL_PLP
				FROM t_respon_plp_tujuan_v2_hdr
				WHERE ID = " . $ID . "";
			$QueryDetail = $conn->query($SQL);
			$QueryDetail->next();
			$NO_PLP = $QueryDetail->get("NO_PLP");
			$TGL_PLP = $QueryDetail->get("TGL_PLP");

			$SQL = "INSERT INTO t_cocostscont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, KD_CONT_TIPE, KD_ISO_CODE, 
										   TEMPERATURE, BRUTO, NO_SEGEL, KONDISI_SEGEL, NO_BL_AWB, TGL_BL_AWB, 
										   NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_POS_BC11, KD_ORG_CONSIGNEE, 
										   KD_TIMBUN_KAPAL, KD_TIMBUN, KD_PEL_MUAT, KD_PEL_TRANSIT, KD_PEL_BONGKAR, 
										   KD_DOK_IN, NO_DOK_IN, TGL_DOK_IN, WK_IN, KD_CONT_STATUS_IN, 
										   KD_SARANA_ANGKUT_IN, NO_POL_IN, KD_DOK_OUT, NO_DOK_OUT, TGL_DOK_OUT, 
										   WK_OUT, KD_CONT_STATUS_OUT, KD_SARANA_ANGKUT_OUT, NO_POL_OUT, 
										   KD_TPS_TUJUAN, KD_GUDANG_TUJUAN, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN, 
										   NO_SEGEL_BC, TGL_SEGEL_BC, NO_IJIN_TPS, TGL_IJIN_TPS, WK_REKAM)
				VALUES (" . $ID_T_COCOSTSHDR . ", " . $NO_CONT . ", " . $UK_CONT . ", " . $JNS_CONT . ", NULL, NULL, 
						NULL, NULL, NULL, NULL, NULL, NULL, 
						NULL, NULL, NULL, NULL, 
						NULL, NULL, NULL, NULL, NULL, 
						'3', '" . $NO_PLP . "', '" . $TGL_PLP . "', NULL, NULL, 
						NULL, NULL, NULL, NULL, NULL, 
						NULL, NULL, NULL, NULL, 
						NULL, NULL, NULL, NULL, 
						NULL, NULL, NULL, NULL, NOW())";
			$Execute = $conn->execute($SQL);
			if($Execute){
				$sqlerror = "Berhasil Insert Kontainer. NO PLP : $NO_PLP";
				$boolean=1;$msg=$sqlerror;
			}else{
				$sqlerror = "Gagal Insert Kontainer. NO PLP : $NO_PLP";
				$boolean=0;$msg=$sqlerror;
			}
		}else{
			$sqlerror = "Berhasil Insert Kontainer. NO PLP : $NO_PLP";
			$boolean=1;$msg=$sqlerror;
		}
	}else{
		$sqlerror = "Gagal Insert Kontainer. NO PLP : $NO_PLP";
		$boolean=0;$msg=$sqlerror;
	}
	return $boolean.'|'.$msg;
}

function display_xml_error($error, $xml) {
    $return  = "";//$xml[$error->line - 1] . "\n";
    //$return .= str_repeat('-', $error->column) . "^\n";

    switch ($error->level) {
        case LIBXML_ERR_WARNING:
            $return .= "Warning $error->code: ";
            break;
        case LIBXML_ERR_ERROR:
            $return .= "Error $error->code: ";
            break;
        case LIBXML_ERR_FATAL:
            $return .= "Fatal Error $error->code: ";
            break;
    }

    $return .= trim($error->message) .
               "\n  Line: $error->line" .
               "\n  Column: $error->column";

    if ($error->file) {
        $return .= "\n  File: $error->file";
    }

    return "$return; \n";
}
?>