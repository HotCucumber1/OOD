#pragma once

#include <cstdint>
#include <iostream>
#include <vector>

class Cipher
{
public:
	explicit Cipher(uint8_t key);

	uint8_t Encrypt(uint8_t byte) const;
	uint8_t Decrypt(uint8_t byte) const;

	void EncryptBlock(const void* srcData, void* dstData, std::streamsize size) const;
	void DecryptBlock(const void* srcData, void* dstData, std::streamsize size) const;

private:
	void GenerateCipher(uint8_t key);

	std::vector<uint8_t> m_encryptionTable;
	std::vector<uint8_t> m_decryptionTable;
};
